<?php
/**
 * handles all stats-mongo-requests
 *
 * @author Hannes Schippmann
 * @author Matthias Pfefferle
 */
class MongoUtils {

  public static function getTopActivityUrl($domain, $fromDate, $toDate, $aggregation, $dealId=null) {
    $topActivities = MongoUtils::getTopActivityUrlData($domain, $fromDate, $toDate, $aggregation, $dealId);
    if($topActivities['data'] && count($topActivities['data']) > 0) {
      return $topActivities['data'][0]['url'];
    } else {
      return null;
    }
  }

  public static function getTopActivityUrlData($domain, $fromDate, $toDate, $aggregation, $dealId=null) {
    return MongoUtils::getTopActivitiesData($domain, $fromDate, $toDate, $aggregation, 1, $dealId);
  }

  public static function getTopActivitiesData($domain, $fromDate, $toDate, $aggregation, $limit=10, $dealId=null) {
    $col = MongoUtils::getCollection('analytics.activities');
    $keys = array("url" => 1);
    $cond = array("host" => $domain, "date" => array('$gte' => new MongoDate(strtotime($fromDate)), '$lte' => new MongoDate(strtotime($toDate))));

    if($dealId) {
      $dealId = intval($dealId);
      $cond['d_id'] = $dealId;
    }

    $initial = array(
      "total" => 0,
      "pos" => 0,
      "neg" => 0,
      "contacts" => 0,
      "clickbacks" => 0,
      "distribution" => 0
    );

    $reduce = "function(doc, out){ ".
                "out.total+=1;".
                "out.pos+=doc.pos==true ? 1 : 0;".
                "out.neg+=doc.pos==false ? 1 : 0;".
                "for(oi in doc.oi) {".
                  "out.contacts+=isNaN(doc.oi[oi].cnt) ? 0 : doc.oi[oi].cnt;".
                "}".
                "if(doc.cb!=undefined && doc.cb!=null) {".
                  "out.clickbacks+=1;".
                "}".
              "}";

    $g = $col->group($keys, $initial, $reduce, array("condition" => $cond));

    $totalTotals = 0;
    for ($i=0; $i < count($g['retval']); $i++) {
      $totalTotals += $g['retval'][$i]['total'];
    }
    for ($i=0; $i < count($g['retval']); $i++) {
      $g['retval'][$i]['distribution'] = round($totalTotals==0 ? 0 : ($g['retval'][$i]['total']/$totalTotals)*100,2);
    }

    $data = array();
    $data['data'] = ChartUtils::sortArrayByTotals($g['retval'], $limit);

    $pi_col = MongoUtils::getCollection('pis', $domain);
    $initial = MongoUtils::getInitial('pis');
    $reduce = MongoUtils::getReduce('pis');
    unset($cond['host']);

    foreach ($data['data'] as $key => $item) {
      $data['data'][$key]['pis'] = array('total' => 0,'cb' => 0,'yiid' => 0);
      $cond['url'] = $item['url'];

      $pis = $pi_col->group($keys, $initial, $reduce, array("condition" => $cond));
      if(!empty($pis['retval'][0])) {
        $data['data'][$key]['pis']['total'] += $pis['retval'][0]['total'];
        $data['data'][$key]['pis']['cb'] += $pis['retval'][0]['cb'];
        $data['data'][$key]['pis']['yiid'] += $pis['retval'][0]['yiid'];
      }
    }

    $data['filter'] = MongoUtils::getFilter($domain, $fromDate, $toDate);

    return $data;
  }

  private static function getCollectionNameForHost($host, $col) {
    return str_replace('.', '_', $host).".analytics.".$col;
  }

  private static function getCollection($col, $host=null) {
    $lCollection = MongoDBConnector::getInstance()
      ->getCollection(sfConfig::get('app_mongodb_database_name_stats'),
        ($host==null ? $col : self::getCollectionNameForHost($host,$col)) );

    $lCollection->ensureIndex(array('date' => -1), array('background' => 1));
    return $lCollection;
  }

  /**
   * Querys the MongoDB and retrieves the raw data through map/reduce
   *
   * @param string $type: The type of data to get. Selects the correct map/reduce functions
   * @param string $domain: The domain used to find the correct collection
   * @param string $fromDate: The fromDate of the range
   * @param string $toDate: The toDate of the range
   * @param string $aggregation: The aggregation type (daily, weekly, monthly)
   * @return array The raw data as it comes from the mongo db
   */
  public static function getDataForRange($type, $domain, $fromDate, $toDate, $aggregation, $url=null, $dealId=null) {
    $type = strstr($type, 'activities') ? 'activities' : 'demografics'; // Merging types
    $col = MongoUtils::getCollection($dealId ? 'deals' : 'charts', $domain);
    
    $keys = array("date" => 1);
    $cond = array("date" => array('$gte' => new MongoDate(strtotime($fromDate)), '$lte' => new MongoDate(strtotime($toDate))));

    if($url) {
      //$cond['url'] = $url;
    }
    
    if($dealId) {
      $dealId = intval($dealId);
      $cond['d_id'] = $dealId;
    }

    $initial = MongoUtils::getInitial($type);
    $reduce = MongoUtils::getReduce($type);

    $g = $col->group($keys, $initial, $reduce, array("condition" => $cond));
    $data['data'] = MongoUtils::getDataWithEmptyDayPadding($g['retval'], $fromDate, $toDate);
    
    $data['filter'] = MongoUtils::getFilter($domain, $fromDate, $toDate, $aggregation);

    if($url) {
      $data['filter']['url'] = $url;
    }

    if($dealId) {
      $data['filter']['deal_id'] = $dealId;
    }

    if($type == 'activities') {
      $pi_col =  MongoUtils::getCollection('pis', $domain);
      $initial = MongoUtils::getInitial('pis');
      $reduce = MongoUtils::getReduce('pis');
      $pis = $pi_col->group($keys, $initial, $reduce, array("condition" => $cond));
      $data['pis'] = MongoUtils::getDataWithEmptyDayPadding($pis['retval'], $fromDate, $toDate);

      $data['statistics'] = MongoUtils::getAdditionalStatistics($g['retval'], $fromDate, $toDate);
    } elseif($type == 'demografics') {
      $data['statistics'] = MongoUtils::getAdditionalDemograficStatistics($data['data'], $fromDate, $toDate);
    }

    return $data;
  }

  private static function getDataWithEmptyDayPadding($mongoData, $fromDate, $toDate) {
    $fullRangeDates = MongoUtils::getMongoDateRange($fromDate, $toDate);

    $dates = array();
    foreach ($mongoData as $data) {
      $dates[] = $data['date'];
    }

    $diff = array_diff($fullRangeDates, $dates);

    $emptyDays = array();
    foreach ($diff as $day) {
      $emptyDays[] = array('date' => $day);
    }
    $res = array_merge($mongoData, $emptyDays);
    return $res;
  }

  private static function initArray() {
    $res = PseudoStatsModel::getPrefilledActivitiesArray();
    $res['activities'] = 0;
    return $res;
  }

  private static function initStats($services) {
    $res = array();
    $res['total'] = array();
    $res['average'] = array();
    $res['ratio'] = array();

    // Initializing the Data arrays for the chart
    foreach ($services as $service) {
      $res['total'][$service] = MongoUtils::initArray();
      $res['average'][$service] = MongoUtils::initArray();
      $res['ratio'][$service] = array('dislike_like' => 0, 'clickback_like' => 0);
    }
    $res['total']['all'] = MongoUtils::initArray();
    $res['average']['all'] = MongoUtils::initArray();
    $res['ratio']['all'] = array('dislike_like' => 0, 'clickback_like' => 0);

    return $res;
  }

  private static function initDemograficStats() {
    $res = array();
    $res['total'] = array();
    $res['ratio'] = array();

    foreach (PseudoStatsModel::$demografics as $demo => $mongoDemoKey) {
      $res['total'][$demo] = $res['ratio'][$demo] = PseudoStatsModel::getPrefilledDemograficsArray($demo);
    }

    return $res;
  }

  private static function getAdditionalDemograficStatistics($mongoData, $fromDate, $toDate) {
    $days = ((strtotime($toDate) - strtotime($fromDate))/(60*60*24))+1;
    $res = MongoUtils::initDemograficStats();

    for ($i=0; $i < count($mongoData); $i++) {
      foreach (PseudoStatsModel::$demografics as $demo => $mongoDemoKey) {
        if(isset($mongoData[$i][$demo])) {
          foreach (PseudoStatsModel::getDemograficsKeys($demo) as $key) {
            $res['total'][$demo][$key] += $mongoData[$i][$demo][$key];
          }
        }
      }
    }

    foreach (PseudoStatsModel::$demografics as $demo => $mongoDemoKey) {
      $res['total'][$demo]['all'] = array_sum($res['total'][$demo]);
    }

    // generate age, gender and relationship ratios
    foreach (PseudoStatsModel::$demografics as $demo => $mongoDemoKey) {
      foreach (PseudoStatsModel::getDemograficsKeys($demo) as $key) {
        $res['ratio'][$demo][$key] = 0;
        if ($res['total'][$demo]['all']!=0) {
          $res['ratio'][$demo][$key] = round($res['total'][$demo][$key]/$res['total'][$demo]['all']*100);
        }
      }
    }

    return $res;
  }

  private static function getAdditionalStatistics($mongoData, $fromDate, $toDate) {
    $services = array('facebook', 'twitter', 'linkedin', 'google');
    $days = ((strtotime($toDate) - strtotime($fromDate))/(60*60*24))+1;
    $res = MongoUtils::initStats($services);

    for ($i=0; $i < count($mongoData); $i++) {
      foreach ($services as $service) {
        foreach (PseudoStatsModel::$activities as $key => $value) {
          $res['total'][$service][$key] += $mongoData[$i][$service][$key];
          $res['total']['all'][$key] += $mongoData[$i][$service][$key];
        }

        $res['total'][$service]['activities'] += $mongoData[$i][$service]['likes']+$mongoData[$i][$service]['dislikes'];
        $res['total']['all']['activities'] += $mongoData[$i][$service]['likes']+$mongoData[$i][$service]['dislikes'];
      }
    }

    foreach ($services as $service) {
      foreach (PseudoStatsModel::$activities as $key => $value) {
        $res['average'][$service][$key] = round($res['total'][$service][$key]/($days==0 ? 1 : $days), 2);
      }

      $res['ratio'][$service]['dislike_like'] = self::getPercentage($res['total'][$service]['likes'], $res['total'][$service]['dislikes']);
      $res['ratio'][$service]['clickback_activities'] = self::getPercentage($res['total'][$service]['activities'], $res['total'][$service]['clickbacks']);
      $res['ratio'][$service]['contacts_activities'] = self::getPercentage($res['total'][$service]['activities'], $res['total'][$service]['contacts']);
      $res['ratio'][$service]['like_percentage'] = self::getPercentage($res['total'][$service]['activities'], $res['total'][$service]['likes']);
      $res['ratio'][$service]['dislike_percentage'] = self::getPercentage($res['total'][$service]['activities'], $res['total'][$service]['dislikes']);
    }

    foreach (PseudoStatsModel::$activities as $key => $value) {
      $res['average']['all'][$key] = round($res['total']['all'][$key]/($days==0 ? 1 : $days), 2);
    }

    $res['ratio']['all']['dislike_like'] = self::getPercentage($res['total']['all']['likes'], $res['total']['all']['dislikes']);
    $res['ratio']['all']['clickback_activities'] = self::getPercentage($res['total']['all']['activities'], $res['total']['all']['clickbacks']);
    $res['ratio']['all']['contacts_activities'] = self::getPercentage($res['total']['all']['activities'], $res['total']['all']['contacts']);
    $res['ratio']['all']['like_percentage'] = self::getPercentage($res['total']['all']['activities'], $res['total']['all']['likes']);
    $res['ratio']['all']['dislike_percentage'] = self::getPercentage($res['total']['all']['activities'], $res['total']['all']['dislikes']);

    return $res;
  }

  private static function getMongoDateRange($start, $end) {
    $range = array();
    $start = strtotime($start);
    $end = strtotime($end);

    do {
      $range[] = new MongoDate($start);
      $start = strtotime("+ 1 day", $start);
    } while($start <= $end);

    return $range;
  }

  private static function getFilter($domain, $fromDate, $toDate, $aggregation='daily') {
    $data = array();
    $data['domain'] = $domain;
    $data['fromDate'] = $fromDate;
    $data['toDate'] = $toDate;
    $data['aggregation'] = $aggregation;
    return $data;
  }

  private static function getInitial($type) {
      switch ($type) {
      case 'activities':
        $res = array();
        foreach (PseudoStatsModel::$services as $service) {
          $res[$service] = PseudoStatsModel::getPrefilledActivitiesArray();
        }
        return $res;
        break;
      case 'demografics':
        $res = array();
        foreach (PseudoStatsModel::$demografics as $demo => $mongoDemoKey) {
          $res[$demo] = PseudoStatsModel::getPrefilledDemograficsArray($demo);
        }
        return $res;
        break;
      case 'pis':
        return array(
          "total" => 0,
          "cb" => 0,
          "yiid" => 0
        );
        break;
      default:
        return null;
        break;
    }
  }

  private static function getReduce($type) {
    switch ($type) {
      case 'activities':
        $res = "function(doc, out) { ";
          foreach (PseudoStatsModel::$services as $service) {
            $res = $res."if(doc.s.".$service.") {";
            foreach (PseudoStatsModel::$activities as $key => $mongoKey) {
              $res = $res."out.".$service."['".$key."'] += ".
                          "isNaN(doc.s.".$service.".".$mongoKey.") ? 0 : doc.s.".$service.".".$mongoKey.";";
            }
            $res = $res."}";
          }
        return $res."}";
        break;
      case 'demografics':
        $res = "function(doc, out) { ";
        foreach (PseudoStatsModel::$demografics as $demo => $mongoDemoKey) {
          $res = $res."if(doc.d.".$mongoDemoKey.") {";
          foreach (PseudoStatsModel::getDemograficsKeys($demo) as $key) {
            $res = $res."out.".$demo."['".$key."'] += ".
                        "isNaN(doc.d.".$mongoDemoKey.".".$key.") ? 0 : doc.d.".$mongoDemoKey.".".$key.";";
          }
          $res = $res."}";
        }
        return $res."}";
        break;
      case 'pis':
        return "function(doc, out){ ".
             "if(doc.total) {".
               "out.total+=isNaN(doc.total) ? 0 : doc.total;".
             "}".
             "if(doc.cb) {".
               "out.cb+=isNaN(doc.cb) ? 0 : doc.cb;".
             "}".
             "if(doc.yiid) {".
               "out.yiid+=isNaN(doc.yiid) ? 0 : doc.yiid;".
             "}".
           "}";
        break;
      default:
        return null;
        break;
    }
  }

  /**
   * creates a percentage value
   *
   * @author Matthias Pfefferle
   * @param int $total
   * @param int $part
   * @return int
   */
  private static function getPercentage($total, $part) {
    if ($total == 0) {
      return 0;
    } else {
      $percent = round($part/$total*100);
      return $percent;
    }
  }
}

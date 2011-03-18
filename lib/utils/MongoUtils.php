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

  public static function getActivityCount($domain, $fromDate, $toDate, $aggregation, $dealId=null) {
    $allActivities = MongoUtils::getTopActivitiesData($domain, $fromDate, $toDate, $aggregation, null, $dealId);
    $count = 0;
    foreach ($allActivities['data'] as $data) {
      $count += $data['total'];
    }
    return $count;
  }
  
  public static function getYesterdaysActivityCountForDomainProfiles($pDomains) {  
    $lActivityCount = array();
    foreach ($pDomains as $domain) {
      $lActivityCount[$domain->getId()] = MongoUtils::getActivityCount($domain->getUrl(), date('Y-m-d', strtotime("1 day ago")), date('Y-m-d'), 'daily');
    }
    arsort($lActivityCount);
    return $lActivityCount;
  }
  
  public static function getYesterdaysTopActivitiesData($domains) {
    return MongoUtils::getTopActivitiesData($domains, date('Y-m-d', strtotime("1 day ago")), date('Y-m-d'), 'daily', 5);
  }
  
  public static function getTopActivitiesData($domain, $fromDate, $toDate, $aggregation, $limit=10, $dealId=null) {
    $col = MongoUtils::getCollection('analytics.activities');
    $keys = array("url" => 1);
    $cond = array("date" => array('$gte' => new MongoDate(strtotime($fromDate)), '$lte' => new MongoDate(strtotime($toDate))));
    
    if(is_array($domain)) {
      $cond['host'] = array('$in' => $domain);
    } else {
      $cond['host'] = $domain;
    }
    
    if($dealId) {
      $dealId = intval($dealId);
      $cond['d_id'] = $dealId;
    } else {
      $cond['d_id'] = array('$exists' => false);
    }

    $initial = array(
      "total" => 0,
      "pos" => 0,
      "neg" => 0,
      "contacts" => 0,
      "clickbacks" => 0,
      "distribution" => 0,
      "title" => ''
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
                "if(doc.title!=undefined && doc.title!=null) {".
                  "out.title = doc.title;".
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
    
    foreach ($data['data'] as $key => $item) {
      $data['data'][$key]['pis'] = array('total' => 0,'cb' => 0,'yiid' => 0);
      
      $pis = MongoUtils::getPisDataForUrl($item['url'], $fromDate, $toDate);

      if(!empty($pis)) {
        $data['data'][$key]['pis']['total'] += array_key_exists('total', $pis) ? $pis['total'] : 0;
        $data['data'][$key]['pis']['cb'] += array_key_exists('cb', $pis) ? $pis['cb'] : 0;
        $data['data'][$key]['pis']['yiid'] += array_key_exists('yiid', $pis) ? $pis['yiid'] : 0;
      }
    }
    
    $data['filter'] = MongoUtils::getFilter($domain, $fromDate, $toDate);
    
    return $data;
  }
  
  private static function getPisDataForUrl($url, $fromDate, $toDate) {
    $host = parse_url($url, PHP_URL_HOST);
    $keys = array("url" => 1);
    $cond = array(
      "url" => $url,
      "date" => array('$gte' => new MongoDate(strtotime($fromDate)), '$lte' => new MongoDate(strtotime($toDate)))
    );
    $pi_col = MongoUtils::getCollection('pis', $host);
    $initial = MongoUtils::getInitial('pis');
    $reduce = MongoUtils::getReduce('pis');
    $g = $pi_col->group($keys, $initial, $reduce, array("condition" => $cond));
    
    $res = count($g['retval']) > 0 ? $g['retval'][0] : array();
    $res['services']['all'] = array("cb" => 0, "yiid" => 0);
    
    foreach (PseudoStatsModel::$services as $service) {
      $res['services'][$service] = array("cb" => 0, "yiid" => 0);
      $res['services'][$service]['cb'] += count($g['retval']) > 0 ? $g['retval'][0]['services'][$service]['cb'] : 0;
      $res['services'][$service]['yiid'] += count($g['retval']) > 0 ?  $g['retval'][0]['services'][$service]['yiid'] : 0;

      $res['services']['all']['cb'] += count($g['retval']) > 0 ? $g['retval'][0]['services'][$service]['cb'] : 0;
      $res['services']['all']['yiid'] += count($g['retval']) > 0 ? $g['retval'][0]['services'][$service]['yiid'] : 0;
    }      
    
    $res['statistics'] = MongoUtils::addPiStatistics($res, $fromDate, $toDate);
    
    return $res;
  }
  
  private static function addPiStatistics($data, $fromDate, $toDate) {
    $days = MongoUtils::getNumberOfDays($fromDate, $toDate);
    $res = array();
    
    $res['average']['all']['cb'] = round($data['services']['all']['cb']/$days, 2);
    foreach (PseudoStatsModel::$services as $service) {
      if(array_key_exists($service, $data['services'])) {
        $res['average'][$service]['cb'] = round($data['services'][$service]['cb']/$days, 2);        
      }
    }
    return $res;
  }
  
  private static function getPisDataForHost($host, $fromDate, $toDate) {
    $keys = array("url" => 1);
    $cond = array(
      "date" => array('$gte' => new MongoDate(strtotime($fromDate)), '$lte' => new MongoDate(strtotime($toDate)))
    );
    $pi_col = MongoUtils::getCollection('pis', $host);
    $initial = MongoUtils::getInitial('pis');
    $reduce = MongoUtils::getReduce('pis');
    $g = $pi_col->group($keys, $initial, $reduce, array("condition" => $cond));
    
    $res = array('total' => 0 , 'cb' => 0, 'yiid' => 0);
    $res['services']['all'] = array("cb" => 0, "yiid" => 0);
    
    foreach (PseudoStatsModel::$services as $service) {
      $res['services'][$service] = array("cb" => 0, "yiid" => 0);
    }
      
    foreach ($g['retval'] as $result) {
      $res['total'] += $result['total'];
      $res['cb'] += $result['cb'];
      $res['yiid'] += $result['yiid'];

      foreach (PseudoStatsModel::$services as $service) {
        $res['services'][$service]['cb'] += $g['retval'][0]['services'][$service]['cb'];
        $res['services'][$service]['yiid'] += $g['retval'][0]['services'][$service]['yiid'];

        $res['services']['all']['cb'] += $g['retval'][0]['services'][$service]['cb'];
        $res['services']['all']['yiid'] += $g['retval'][0]['services'][$service]['yiid'];
      }
    }

    $res['statistics'] = MongoUtils::addPiStatistics($res, $fromDate, $toDate);

    return $res;
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
    $cond = array();

    if($url) {
      $cond['url'] = $url;
    }
    
    if($dealId) {
      $dealId = intval($dealId);  
      $cond['d_id'] = $dealId;
    } else {
      $cond['date'] = array('$gte' => new MongoDate(strtotime($fromDate)), '$lte' => new MongoDate(strtotime($toDate)));
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
      #$data['pis'] = MongoUtils::getDataWithEmptyDayPadding($pis['retval'], $fromDate, $toDate);

      if($url) {
        $data['pis'] = MongoUtils::getPisDataForUrl($url, $fromDate, $toDate);
      } else {
        $data['pis'] = MongoUtils::getPisDataForHost($domain, $fromDate, $toDate);
      }
      
      $data['statistics'] = MongoUtils::getAdditionalStatistics($g['retval'], $data['pis'], $fromDate, $toDate);
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
  
  private static function getNumberOfDays($fromDate, $toDate, $zeroSafe=true) {
    $days = ((strtotime($toDate) - strtotime($fromDate))/(60*60*24))+1;
    return ($days==0 ? 1 : $days);
  }
  
  private static function getAdditionalStatistics($mongoData, $piData,  $fromDate, $toDate) {
    $services = PseudoStatsModel::$services;
    $days = MongoUtils::getNumberOfDays($fromDate, $toDate);
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
      $res['ratio'][$service]['clickback_activities'] = self::getPercentage($res['total'][$service]['activities'], $piData['services'][$service]['cb']);
      $res['ratio'][$service]['contacts_activities'] = self::getPercentage($res['total'][$service]['activities'], $res['total'][$service]['contacts']);
      $res['ratio'][$service]['like_percentage'] = self::getPercentage($res['total'][$service]['activities'], $res['total'][$service]['likes']);
      $res['ratio'][$service]['dislike_percentage'] = self::getPercentage($res['total'][$service]['activities'], $res['total'][$service]['dislikes']);
    }
        
    foreach (PseudoStatsModel::$activities as $key => $value) {
      $res['average']['all'][$key] = round($res['total']['all'][$key]/($days==0 ? 1 : $days), 2);
    }

    $res['ratio']['all']['dislike_like'] = self::getPercentage($res['total']['all']['likes'], $res['total']['all']['dislikes']);
    $res['ratio']['all']['clickback_activities'] = self::getPercentage($res['total']['all']['activities'], $piData['services']['all']['cb']);
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
          "yiid" => 0,
          "services" => array(
            "facebook" => array("cb" => 0, "yiid" => 0),
            "twitter" => array("cb" => 0, "yiid" => 0),
            "linkedin" => array("cb" => 0, "yiid" => 0),
            "google" => array("cb" => 0, "yiid" => 0)
          )
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
        $res = "function(doc, out){ ".
         "if(doc.total) {".
           "out.total+=isNaN(doc.total) ? 0 : doc.total;".
         "}".
         "if(doc.cb) {".
           "out.cb+=isNaN(doc.cb) ? 0 : doc.cb;".
         "}".
         "if(doc.yiid) {".
           "out.yiid+=isNaN(doc.yiid) ? 0 : doc.yiid;".
         "}";
          foreach (PseudoStatsModel::$services as $service) {
            $res = $res."if(doc.s && doc.s.".$service.") {".
              "out.services.".$service.".cb+=".
                "isNaN(doc.s.".$service.".cb) ? 0 : doc.s.".$service.".cb;".
              "out.services.".$service.".yiid+=".
                "isNaN(doc.s.".$service.".yiid) ? 0 : doc.s.".$service.".yiid;".
            "}";
          }
        return $res."}";
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
      $percent = round(($part/$total)*100);
      return $percent;
    }
  }
}

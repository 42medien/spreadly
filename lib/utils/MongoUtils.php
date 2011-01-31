<?php

class MongoUtils {
  // Hi
  public static function getTopActivityUrl($domain, $fromDate, $toDate, $aggregation) {
    $topActivities = MongoUtils::getTopActivityUrlData($domain, $fromDate, $toDate, $aggregation);
    return $topActivities['data'][0]['url'];
  }

  public static function getTopActivityUrlData($domain, $fromDate, $toDate, $aggregation) {
    return MongoUtils::getTopActivitiesData($domain, $fromDate, $toDate, $aggregation, 1);
  }

  public static function getTopActivitiesData($domain, $fromDate, $toDate, $aggregation, $limit=10) {
    $col = MongoUtils::getCollection('analytics.activities');
    $keys = array("url" => 1);
    $cond = array("host" => $domain, "date" => array('$gte' => new MongoDate(strtotime($fromDate)), '$lte' => new MongoDate(strtotime($toDate))));

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
  public static function getDataForRange($type, $domain, $fromDate, $toDate, $aggregation, $url=null) {
    $type = strstr($type, 'activities') ? 'activities' : 'demografics'; // Merging types
    $col = MongoUtils::getCollection('charts', $domain);

    $keys = array("date" => 1);
    $cond = array("date" => array('$gte' => new MongoDate(strtotime($fromDate)), '$lte' => new MongoDate(strtotime($toDate))));

    if($url) {
      $cond['url'] = $url;
    }

    $initial = MongoUtils::getInitial($type);
    $reduce = MongoUtils::getReduce($type);

    $g = $col->group($keys, $initial, $reduce, array("condition" => $cond));

    $data['data'] = MongoUtils::getDataWithEmptyDayPadding($g['retval'], $fromDate, $toDate);

    $data['filter'] = MongoUtils::getFilter($domain, $fromDate, $toDate, $aggregation);

    if($url) {
      $data['filter']['url'] = $url;
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
    $res = array();
    $res['likes'] = 0;
    $res['dislikes'] = 0;
    $res['activities'] = 0;
    $res['clickbacks'] = 0;
    $res['contacts'] = 0;
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

    $res['total']['age'] = $res['ratio']['age'] = PseudoStatsModel::getPrefilledAgeArray();
    $res['total']['gender'] = $res['ratio']['gender'] = PseudoStatsModel::getPrefilledGenderArray();
    $res['total']['relationship'] = $res['ratio']['relationship'] = PseudoStatsModel::getPrefilledRelationshipArray();

    return $res;
  }

  private static function getAdditionalDemograficStatistics($mongoData, $fromDate, $toDate) {
    $days = ((strtotime($toDate) - strtotime($fromDate))/(60*60*24))+1;
    $res = MongoUtils::initDemograficStats();

    for ($i=0; $i < count($mongoData); $i++) {
      if(isset($mongoData[$i]['age'])) {
        foreach (PseudoStatsModel::$age as $age) {
          $res['total']['age'][$age]    += $mongoData[$i]['age'][$age]   ;
        }
      }

      if(isset($mongoData[$i]['gender'])) {
        foreach (PseudoStatsModel::$gender as $gender) {
          $res['total']['gender'][$gender] += $mongoData[$i]['gender'][$gender];
        }
      }

      if(isset($mongoData[$i]['relationship'])) {
        foreach (PseudoStatsModel::$relationship as $rel) {
          $res['total']['relationship'][$rel]  += $mongoData[$i]['relationship'][$rel];
        }
      }
    }

    $res['total']['age']['all']    =  array_sum($res['total']['age']);
    $res['total']['gender']['all'] =  array_sum($res['total']['gender']);
    $res['total']['relationship']['all'] =  array_sum($res['total']['relationship']);

    // generate age ratio
    foreach (PseudoStatsModel::$age as $age) {
      $res['ratio']['age'][$age] = 0;
      if ($res['total']['age']['all']!=0) {
        $res['ratio']['age'][$age]    = round($res['total']['age'][$age]/$res['total']['age']['all']*100);
      }
    }

    // generate gender ratio
    foreach (PseudoStatsModel::$gender as $gender) {
      $res['ratio']['gender'][$gender] = 0;
      if ($res['total']['gender']['all'] != 0) {
        $res['ratio']['gender'][$gender] = round($res['total']['gender'][$gender]/$res['total']['gender']['all']*100);
      }
    }

    // generate relationship ratio
    foreach (PseudoStatsModel::$relationship as $rel) {
      $res['ratio']['relationship'][$rel] = 0;
      if ($res['total']['relationship']['all'] != 0) {
        $res['ratio']['relationship'][$rel] = round($res['total']['relationship'][$rel]/$res['total']['relationship']['all']*100);
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
      $res['average'][$service]['likes'] = round($res['total'][$service]['likes']/($days==0 ? 1 : $days), 2);
      $res['average'][$service]['dislikes'] = round($res['total'][$service]['dislikes']/($days==0 ? 1 : $days), 2);
      $res['average'][$service]['clickbacks'] = round($res['total'][$service]['clickbacks']/($days==0 ? 1 : $days), 2);

      $res['average'][$service]['contacts'] = round($res['total'][$service]['contacts']/($days==0 ? 1 : $days), 2);

      $res['ratio'][$service]['dislike_like'] = self::getPercentage($res['total'][$service]['likes'], $res['total'][$service]['dislikes']);
      $res['ratio'][$service]['clickback_activities'] = self::getPercentage($res['total'][$service]['activities'], $res['total'][$service]['clickbacks']);
      $res['ratio'][$service]['contacts_activities'] = self::getPercentage($res['total'][$service]['activities'], $res['total'][$service]['contacts']);
      $res['ratio'][$service]['like_percentage'] = self::getPercentage($res['total'][$service]['activities'], $res['total'][$service]['likes']);
      $res['ratio'][$service]['dislike_percentage'] = self::getPercentage($res['total'][$service]['activities'], $res['total'][$service]['dislikes']);
    }

    $res['average']['all']['likes'] = round($res['total']['all']['likes']/($days==0 ? 1 : $days), 2);
    $res['average']['all']['dislikes'] = round($res['total']['all']['dislikes']/($days==0 ? 1 : $days), 2);
    $res['average']['all']['clickbacks'] = round($res['total']['all']['clickbacks']/($days==0 ? 1 : $days), 2);

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
        return array(
          "facebook" => array("likes" => 0, "dislikes" => 0, "clickbacks" => 0, "contacts" => 0),
          "twitter" => array("likes" => 0, "dislikes" => 0, "clickbacks" => 0, "contacts" => 0),
          "linkedin" => array("likes" => 0, "dislikes" => 0, "clickbacks" => 0, "contacts" => 0),
          "google" => array("likes" => 0, "dislikes" => 0, "clickbacks" => 0, "contacts" => 0)
        );
        break;
      case 'demografics':
        return array(
          "age" => PseudoStatsModel::getPrefilledAgeArray(),
          "gender" => PseudoStatsModel::getPrefilledGenderArray(),
          "relationship" => PseudoStatsModel::getPrefilledRelationshipArray()
        );
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
        return "function(doc, out){ ".
             "if(doc.s.facebook) {".
               "out.facebook['likes']+=isNaN(doc.s.facebook.pos) ? 0 : doc.s.facebook.pos;".
               "out.facebook['dislikes']+=isNaN(doc.s.facebook.neg) ? 0 : doc.s.facebook.neg;".
               "out.facebook['clickbacks']+=isNaN(doc.s.facebook.cb) ? 0 : doc.s.facebook.cb;".
               "out.facebook['contacts']+=isNaN(doc.s.facebook.cnt) ? 0 : doc.s.facebook.cnt;".
             "}".
             "if(doc.s.twitter) {".
               "out.twitter['likes']+=isNaN(doc.s.twitter.pos) ? 0 : doc.s.twitter.pos;".
               "out.twitter['dislikes']+=isNaN(doc.s.twitter.neg) ? 0 : doc.s.twitter.neg;".
               "out.twitter['clickbacks']+=isNaN(doc.s.twitter.cb) ? 0 : doc.s.twitter.cb;".
               "out.twitter['contacts']+=isNaN(doc.s.twitter.cnt) ? 0 : doc.s.twitter.cnt;".
             "}".
             "if(doc.s.linkedin) {".
               "out.linkedin['likes']+=isNaN(doc.s.linkedin.pos) ? 0 : doc.s.linkedin.pos;".
               "out.linkedin['dislikes']+=isNaN(doc.s.linkedin.neg) ? 0 : doc.s.linkedin.neg;".
               "out.linkedin['clickbacks']+=isNaN(doc.s.linkedin.cb) ? 0 : doc.s.linkedin.cb;".
               "out.linkedin['contacts']+=isNaN(doc.s.linkedin.cnt) ? 0 : doc.s.linkedin.cnt;".
             "}".
             "if(doc.s.google) {".
               "out.google['likes']+=isNaN(doc.s.google.pos) ? 0 : doc.s.google.pos;".
               "out.google['dislikes']+=isNaN(doc.s.google.neg) ? 0 : doc.s.google.neg;".
               "out.google['clickbacks']+=isNaN(doc.s.google.cb) ? 0 : doc.s.google.cb;".
               "out.google['contacts']+=isNaN(doc.s.google.cnt) ? 0 : doc.s.google.cnt;".
             "}".
           "}";
        break;
      case 'demografics':
        return "function(doc, out){ ".
             "if(doc.d.age) {".
               "out.age.u_18+=isNaN(doc.d.age.u_18) ? 0 : doc.d.age.u_18;".
               "out.age.b_18_24+=isNaN(doc.d.age.b_18_24) ? 0 : doc.d.age.b_18_24;".
               "out.age.b_25_34+=isNaN(doc.d.age.b_25_34) ? 0 : doc.d.age.b_25_34;".
               "out.age.b_35_54+=isNaN(doc.d.age.b_35_54) ? 0 : doc.d.age.b_35_54;".
               "out.age.o_55+=isNaN(doc.d.age.o_55) ? 0 : doc.d.age.o_55;".
             "}".
             "if(doc.d.sex) {".
               "out.gender.m+=isNaN(doc.d.sex.m) ? 0 : doc.d.sex.m;".
               "out.gender.f+=isNaN(doc.d.sex.f) ? 0 : doc.d.sex.f;".
               "out.gender.u+=isNaN(doc.d.sex.u) ? 0 : doc.d.sex.u;".
             "}".
             "if(doc.d.rel) {".
               "out.relationship.singl+=isNaN(doc.d.rel.singl) ? 0 : doc.d.rel.singl;".
               "out.relationship.eng+=isNaN(doc.d.rel.eng) ? 0 : doc.d.rel.eng;".
               "out.relationship.compl+=isNaN(doc.d.rel.compl) ? 0 : doc.d.rel.compl;".
               "out.relationship.mar+=isNaN(doc.d.rel.mar) ? 0 : doc.d.rel.mar;".
               "out.relationship.rel+=isNaN(doc.d.rel.rel) ? 0 : doc.d.rel.rel;".
               "out.relationship.ior+=isNaN(doc.d.rel.ior) ? 0 : doc.d.rel.ior;".
               "out.relationship.wid+=isNaN(doc.d.rel.wid) ? 0 : doc.d.rel.wid;".
               "out.relationship.u+=isNaN(doc.d.rel.u) ? 0 : doc.d.rel.u;".
             "}".
           "}";
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
    if ($total = 0) {
      return 0;
    } else {
      $percent = round($part/$total*100);
      return $percent;
    }
  }
}
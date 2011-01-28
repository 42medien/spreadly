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
   * @param type: The type of data to get. Selects the correct map/reduce functions
   * @param domain: The domain used to find the correct collection
   * @param fromDate: The fromDate of the range
   * @param toDate: The toDate of the range
   * @param aggregation: The aggregation type (daily, weekly, monthly)
   * @return The raw data as it comes from the mongo db
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
      $res['ratio'][$service] = array();
      $res['ratio'][$service]['dislike_like'] = 0;
      $res['ratio'][$service]['clickback_like'] = 0;
    }
    $res['total']['all'] = MongoUtils::initArray();
    $res['average']['all'] = MongoUtils::initArray();
    $res['ratio']['all'] = array();
    $res['ratio']['all']['dislike_like'] = 0;
    $res['ratio']['all']['clickback_like'] = 0;

    return $res;
  }

  private static function initDemograficStats() {
    $res = array();
    $res['total'] = array();
    $res['ratio'] = array();

    $res['total']['age'] = array(
              "u_18" => 0,
              "b_18_24" => 0,
              "b_25_34" => 0,
              "b_35_54" => 0,
              "o_55" => 0
          );

    $res['total']['gender'] = array(
              "m" => 0,
              "f" => 0,
              "u" => 0
          );
    $res['total']['relationship'] = array(
              "singl" => 0,
              "eng" => 0,
              "compl" => 0,
              "mar" => 0,
              "rel" => 0,
              "ior" => 0,
              "wid" => 0,
              "u" => 0
          );

    $res['ratio']['age'] = array(
              "u_18" => 0,
              "b_18_24" => 0,
              "b_25_34" => 0,
              "b_35_54" => 0,
              "o_55" => 0
          );

    $res['ratio']['gender'] = array(
              "m" => 0,
              "f" => 0,
              "u" => 0
          );
    $res['ratio']['relationship'] = array(
              "singl" => 0,
              "eng" => 0,
              "compl" => 0,
              "mar" => 0,
              "rel" => 0,
              "ior" => 0,
              "wid" => 0,
              "u" => 0
          );

    return $res;
  }

  private static function getAdditionalDemograficStatistics($mongoData, $fromDate, $toDate) {
    $days = ((strtotime($toDate) - strtotime($fromDate))/(60*60*24))+1;
    $res = MongoUtils::initDemograficStats();

    for ($i=0; $i < count($mongoData); $i++) {
      if(isset($mongoData[$i]['age'])) {
        $res['total']['age']['u_18']    += $mongoData[$i]['age']['u_18']   ;
        $res['total']['age']['b_18_24'] += $mongoData[$i]['age']['b_18_24'];
        $res['total']['age']['b_25_34'] += $mongoData[$i]['age']['b_25_34'];
        $res['total']['age']['b_35_54'] += $mongoData[$i]['age']['b_35_54'];
        $res['total']['age']['o_55']    += $mongoData[$i]['age']['o_55']   ;
      }

      if(isset($mongoData[$i]['gender'])) {
        $res['total']['gender']['m'] += $mongoData[$i]['gender']['m'];
        $res['total']['gender']['f'] += $mongoData[$i]['gender']['f'];
        $res['total']['gender']['u'] += $mongoData[$i]['gender']['u'];
      }

      if(isset($mongoData[$i]['relationship'])) {
        $res['total']['relationship']['singl']  += $mongoData[$i]['relationship']['singl'];
        $res['total']['relationship']['eng']    += $mongoData[$i]['relationship']['eng']  ;
        $res['total']['relationship']['compl']  += $mongoData[$i]['relationship']['compl'];
        $res['total']['relationship']['mar']    += $mongoData[$i]['relationship']['mar']  ;
        $res['total']['relationship']['rel']    += $mongoData[$i]['relationship']['rel']  ;
        $res['total']['relationship']['ior']    += $mongoData[$i]['relationship']['ior']  ;
        $res['total']['relationship']['wid']    += $mongoData[$i]['relationship']['wid']  ;
        $res['total']['relationship']['u']      += $mongoData[$i]['relationship']['u']    ;
      }
    }

    $res['total']['age']['all']    =  array_sum($res['total']['age']);
    $res['total']['gender']['all'] =  array_sum($res['total']['gender']);
    $res['total']['relationship']['all'] =  array_sum($res['total']['relationship']);

    $res['ratio']['age']['u_18']    = round($res['total']['age']['u_18']   /($res['total']['age']['all']==0 ? 1 : $res['total']['age']['all'])*100);
    $res['ratio']['age']['b_18_24'] = round($res['total']['age']['b_18_24']/($res['total']['age']['all']==0 ? 1 : $res['total']['age']['all'])*100);
    $res['ratio']['age']['b_25_34'] = round($res['total']['age']['b_25_34']/($res['total']['age']['all']==0 ? 1 : $res['total']['age']['all'])*100);
    $res['ratio']['age']['b_35_54'] = round($res['total']['age']['b_35_54']/($res['total']['age']['all']==0 ? 1 : $res['total']['age']['all'])*100);
    $res['ratio']['age']['o_55']    = round($res['total']['age']['o_55']   /($res['total']['age']['all']==0 ? 1 : $res['total']['age']['all'])*100);

    $res['ratio']['gender']['m'] = round($res['total']['gender']['m']/($res['total']['gender']['all']==0 ? 1 : $res['total']['gender']['all'])*100);
    $res['ratio']['gender']['f'] = round($res['total']['gender']['f']/($res['total']['gender']['all']==0 ? 1 : $res['total']['gender']['all'])*100);
    $res['ratio']['gender']['u'] = round($res['total']['gender']['u']/($res['total']['gender']['all']==0 ? 1 : $res['total']['gender']['all'])*100);

    $res['ratio']['relationship']['singl']  = round($res['total']['relationship']['singl']/($res['total']['relationship']['all']==0 ? 1 : $res['total']['relationship']['all'])*100);
    $res['ratio']['relationship']['eng']    = round($res['total']['relationship']['eng']  /($res['total']['relationship']['all']==0 ? 1 : $res['total']['relationship']['all'])*100);
    $res['ratio']['relationship']['compl']  = round($res['total']['relationship']['compl']/($res['total']['relationship']['all']==0 ? 1 : $res['total']['relationship']['all'])*100);
    $res['ratio']['relationship']['mar']    = round($res['total']['relationship']['mar']  /($res['total']['relationship']['all']==0 ? 1 : $res['total']['relationship']['all'])*100);
    $res['ratio']['relationship']['rel']    = round($res['total']['relationship']['rel']  /($res['total']['relationship']['all']==0 ? 1 : $res['total']['relationship']['all'])*100);
    $res['ratio']['relationship']['ior']    = round($res['total']['relationship']['ior']  /($res['total']['relationship']['all']==0 ? 1 : $res['total']['relationship']['all'])*100);
    $res['ratio']['relationship']['wid']    = round($res['total']['relationship']['wid']  /($res['total']['relationship']['all']==0 ? 1 : $res['total']['relationship']['all'])*100);
    $res['ratio']['relationship']['u']      = round($res['total']['relationship']['u']    /($res['total']['relationship']['all']==0 ? 1 : $res['total']['relationship']['all'])*100);

    return $res;
  }

  private static function getAdditionalStatistics($mongoData, $fromDate, $toDate) {
    $services = array('facebook', 'twitter', 'linkedin', 'google');
    $days = ((strtotime($toDate) - strtotime($fromDate))/(60*60*24))+1;
    $res = MongoUtils::initStats($services);

    for ($i=0; $i < count($mongoData); $i++) {
      foreach ($services as $service) {
        $res['total'][$service]['likes'] += $mongoData[$i][$service]['likes'];
        $res['total'][$service]['dislikes'] += $mongoData[$i][$service]['dislikes'];
        $res['total'][$service]['activities'] += $mongoData[$i][$service]['likes']+$mongoData[$i][$service]['dislikes'];
        $res['total'][$service]['clickbacks'] += $mongoData[$i][$service]['clickbacks'];
        $res['total'][$service]['contacts'] += $mongoData[$i][$service]['contacts'];

        $res['total']['all']['likes'] += $mongoData[$i][$service]['likes'];
        $res['total']['all']['dislikes'] += $mongoData[$i][$service]['dislikes'];
        $res['total']['all']['activities'] += $mongoData[$i][$service]['likes']+$mongoData[$i][$service]['dislikes'];
        $res['total']['all']['clickbacks'] += $mongoData[$i][$service]['clickbacks'];
        $res['total']['all']['contacts'] += $mongoData[$i][$service]['contacts'];
      }
    }

    foreach ($services as $service) {
      $res['average'][$service]['likes'] = round($res['total'][$service]['likes']/($days==0 ? 1 : $days), 2);
      $res['average'][$service]['dislikes'] = round($res['total'][$service]['dislikes']/($days==0 ? 1 : $days), 2);
      $res['average'][$service]['clickbacks'] = round($res['total'][$service]['clickbacks']/($days==0 ? 1 : $days), 2);

      $res['average'][$service]['contacts'] = round($res['total'][$service]['contacts']/($days==0 ? 1 : $days), 2);

      $res['ratio'][$service]['dislike_like'] =
        $res['total'][$service]['likes'] == 0 ? 0 :  round($res['total'][$service]['dislikes']/$res['total'][$service]['likes']*100);

      $res['ratio'][$service]['clickback_activities'] =
        $res['total'][$service]['activities'] == 0 ? 0 :  round($res['total'][$service]['clickbacks']/$res['total'][$service]['activities']*100);

      $res['ratio'][$service]['contacts_activities'] =
        $res['total'][$service]['activities'] == 0 ? 0 :  round($res['total'][$service]['contacts']/$res['total'][$service]['activities']*100);

      $res['ratio'][$service]['like_percentage'] =
        ($res['total'][$service]['activities']) == 0 ? 0 :  round($res['total'][$service]['likes']/($res['total'][$service]['activities'])*100);

      $res['ratio'][$service]['dislike_percentage'] =
        ($res['total'][$service]['activities']) == 0 ? 0 :  round($res['total'][$service]['dislikes']/($res['total'][$service]['activities'])*100);

    }

    $res['average']['all']['likes'] = round($res['total']['all']['likes']/($days==0 ? 1 : $days), 2);
    $res['average']['all']['dislikes'] = round($res['total']['all']['dislikes']/($days==0 ? 1 : $days), 2);
    $res['average']['all']['clickbacks'] = round($res['total']['all']['clickbacks']/($days==0 ? 1 : $days), 2);

    $res['ratio']['all']['dislike_like'] =
      $res['total']['all']['likes'] == 0 ? 0 :  round($res['total']['all']['dislikes']/$res['total']['all']['likes']*100);

    $res['ratio']['all']['clickback_activities'] =
      $res['total']['all']['activities'] == 0 ? 0 :  round($res['total']['all']['clickbacks']/$res['total']['all']['activities']*100);

    $res['ratio']['all']['contacts_activities'] =
      $res['total']['all']['activities'] == 0 ? 0 :  round($res['total']['all']['contacts']/$res['total']['all']['activities']*100);

    $res['ratio']['all']['like_percentage'] =
      ($res['total']['all']['activities']) == 0 ? 0 :  round($res['total']['all']['likes']/($res['total']['all']['activities'])*100);

    $res['ratio']['all']['dislike_percentage'] =
      ($res['total']['all']['activities']) == 0 ? 0 :  round($res['total']['all']['dislikes']/($res['total']['all']['activities'])*100);

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
          "age" => array(
              "u_18" => 0,
              "b_18_24" => 0,
              "b_25_34" => 0,
              "b_35_54" => 0,
              "o_55" => 0
          ),
          "gender" => array(
              "m" => 0,
              "f" => 0,
              "u" => 0
          ),
          "relationship" => array(
              "singl" => 0,
              "eng" => 0,
              "compl" => 0,
              "mar" => 0,
              "rel" => 0,
              "ior" => 0,
              "wid" => 0,
              "u" => 0
          )
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
}
<?php

class MongoUtils {

  public static function getActivityData($domain, $fromDate, $toDate, $aggregation) {
    return MongoUtils::getDataForRange('activities_with_clickbacks', $domain, $fromDate, $toDate, $aggregation);
  }

  public static function getAgeData($domain, $fromDate, $toDate, $aggregation) {
    return MongoUtils::getDataForRange('age_distribution', $domain, $fromDate, $toDate, $aggregation);
  }

  public static function getGenderData($domain, $fromDate, $toDate, $aggregation) {
    return MongoUtils::getDataForRange('gender_distribution', $domain, $fromDate, $toDate, $aggregation);
  }

  public static function getRelationshipData($domain, $fromDate, $toDate, $aggregation) {
    return MongoUtils::getDataForRange('relationship_status', $domain, $fromDate, $toDate, $aggregation);
  }

  public static function getMediaPenetrationData($domain, $fromDate, $toDate, $aggregation) {
    return MongoUtils::getDataForRange('media_penetration_with_clickbacks', $domain, $fromDate, $toDate, $aggregation);
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
      "clickbacks" => 0
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
  private static function getDataForRange($type, $domain, $fromDate, $toDate, $aggregation, $url=null) {
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
    if(strstr($type, 'with_clickbacks')) {
      $pi_col =  MongoUtils::getCollection('pis', $domain);
      $initial = MongoUtils::getInitial('pis');
      $reduce = MongoUtils::getReduce('pis');
      $pis = $pi_col->group($keys, $initial, $reduce, array("condition" => $cond));
      $data['pis'] = MongoUtils::getDataWithEmptyDayPadding($pis['retval'], $fromDate, $toDate);
    }
    
    $data['filter'] = MongoUtils::getFilter($domain, $fromDate, $toDate, $aggregation);
    
    $data['statistics'] = MongoUtils::getAdditionalStatistics($g['retval'], $fromDate, $toDate);
    var_dump($data);exit;
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
  
  private static function getAdditionalStatistics($mongoData, $fromDate, $toDate) {
    $res = array();
    $res['total'] = array();
    $res['average'] = array();
    $res['ratio'] = array();
  
    $days = (strtotime($toDate) - strtotime($fromDate))/(60*60*24);
    
    $services = array('facebook', 'twitter', 'linkedin', 'google');

    // Initializing the Data arrays for the chart
    foreach ($services as $service) {
      $res['total'][$service] = array();
      $res['total'][$service]['likes'] = 0;
      $res['total'][$service]['dislikes'] = 0; 
      $res['total'][$service]['clickbacks'] = 0;
      $res['average'][$service] = array();
      $res['average'][$service]['likes'] = 0;
      $res['average'][$service]['dislikes'] = 0; 
      $res['average'][$service]['clickbacks'] = 0;
      $res['ratio'][$service] = array();
      $res['ratio'][$service]['dislike_like'] = 0;
      $res['ratio'][$service]['clickback_like'] = 0;      
    }
    $res['total']['all'] = array();
    $res['total']['all']['likes'] = 0;
    $res['total']['all']['dislikes'] = 0; 
    $res['total']['all']['clickbacks'] = 0;
    $res['average']['all'] = array();
    $res['average']['all']['likes'] = 0;
    $res['average']['all']['dislikes'] = 0; 
    $res['average']['all']['clickbacks'] = 0;
    $res['ratio']['all'] = array();
    $res['ratio']['all']['dislike_like'] = 0;
    $res['ratio']['all']['clickback_like'] = 0;

  
    for ($i=0; $i < count($mongoData); $i++) { 
      foreach ($services as $service) {
        $res['total'][$service]['likes'] += $mongoData[$i][$service]['likes'];
        $res['total'][$service]['dislikes'] += $mongoData[$i][$service]['dislikes'];
        $res['total'][$service]['clickbacks'] += $mongoData[$i][$service]['clickbacks'];

        $res['total']['all']['likes'] += $mongoData[$i][$service]['likes'];
        $res['total']['all']['dislikes'] += $mongoData[$i][$service]['dislikes'];
        $res['total']['all']['clickbacks'] += $mongoData[$i][$service]['clickbacks'];
      }
    }
    
    foreach ($services as $service) {
      $res['average'][$service]['likes'] = round($res['total'][$service]['likes']/$days, 2);
      $res['average'][$service]['dislikes'] = round($res['total'][$service]['dislikes']/$days, 2);
      $res['average'][$service]['clickbacks'] = round($res['total'][$service]['clickbacks']/$days, 2);
      
      $res['ratio'][$service]['dislike_like'] = round($res['total'][$service]['dislikes']/$res['total'][$service]['likes']*100);
      $res['ratio'][$service]['clickback_like'] = round($res['total'][$service]['clickbacks']/$res['total'][$service]['likes']*100);
    }
    
    $res['average']['all']['likes'] = round($res['total']['all']['likes']/$days, 2);
    $res['average']['all']['dislikes'] = round($res['total']['all']['dislikes']/$days, 2);
    $res['average']['all']['clickbacks'] = round($res['total']['all']['clickbacks']/$days, 2);

    $res['ratio']['all']['dislike_like'] = round($res['total']['all']['dislikes']/$res['total']['all']['likes']*100);
    $res['ratio']['all']['clickback_like'] = round($res['total']['all']['clickbacks']/$res['total']['all']['likes']*100);
    
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
      case 'activities_with_clickbacks':
        return array(
          "facebook" => array("likes" => 0, "dislikes" => 0, "clickbacks" => 0),
          "twitter" => array("likes" => 0, "dislikes" => 0, "clickbacks" => 0),
          "linkedin" => array("likes" => 0, "dislikes" => 0, "clickbacks" => 0),
          "google" => array("likes" => 0, "dislikes" => 0, "clickbacks" => 0)
        );
        break;
      case 'age_distribution':
        return array(
          "u_18" => 0,
          "b_18_24" => 0,
          "b_25_34" => 0,
          "b_35_54" => 0,
          "o_55" => 0
        );
        break;
      case 'gender_distribution':
        return array(
          "m" => 0,
          "f" => 0,
          "u" => 0
        );
        break;
      case 'relationship_status':
        return array(
          "singl" => 0,
          "eng" => 0,
          "compl" => 0,
          "mar" => 0,
          "rel" => 0,
          "ior" => 0,
          "wid" => 0,
          "u" => 0
        );
        break;
      case 'media_penetration_with_clickbacks':
        return array(
          "facebook" => array("contacts" => 0, "clickbacks" => 0),
          "twitter" => array("contacts" => 0, "clickbacks" => 0),
          "linkedin" => array("contacts" => 0, "clickbacks" => 0),
          "google" => array("contacts" => 0, "clickbacks" => 0)
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
      case 'activities_with_clickbacks':
        return "function(doc, out){ ".
             "if(doc.s.facebook) {".
               "out.facebook['likes']+=isNaN(doc.s.facebook.pos) ? 0 : doc.s.facebook.pos;".
               "out.facebook['dislikes']+=isNaN(doc.s.facebook.neg) ? 0 : doc.s.facebook.neg;".
               "out.facebook['clickbacks']+=isNaN(doc.s.facebook.cb) ? 0 : doc.s.facebook.cb;".
             "}".
             "if(doc.s.twitter) {".
               "out.twitter['likes']+=isNaN(doc.s.twitter.pos) ? 0 : doc.s.twitter.pos;".
               "out.twitter['dislikes']+=isNaN(doc.s.twitter.neg) ? 0 : doc.s.twitter.neg;".
               "out.twitter['clickbacks']+=isNaN(doc.s.twitter.cb) ? 0 : doc.s.twitter.cb;".
             "}".
             "if(doc.s.linkedin) {".
               "out.linkedin['likes']+=isNaN(doc.s.linkedin.pos) ? 0 : doc.s.linkedin.pos;".
               "out.linkedin['dislikes']+=isNaN(doc.s.linkedin.neg) ? 0 : doc.s.linkedin.neg;".
               "out.linkedin['clickbacks']+=isNaN(doc.s.linkedin.cb) ? 0 : doc.s.linkedin.cb;".
             "}".
             "if(doc.s.google) {".
               "out.google['likes']+=isNaN(doc.s.google.pos) ? 0 : doc.s.google.pos;".
               "out.google['dislikes']+=isNaN(doc.s.google.neg) ? 0 : doc.s.google.neg;".
               "out.google['clickbacks']+=isNaN(doc.s.google.cb) ? 0 : doc.s.google.cb;".
             "}".
           "}";
        break;
      case 'age_distribution':
        return "function(doc, out){ ".
             "if(doc.d.age) {".
               "out.u_18+=isNaN(doc.d.age.u_18) ? 0 : doc.d.age.u_18;".
               "out.b_18_24+=isNaN(doc.d.age.b_18_24) ? 0 : doc.d.age.b_18_24;".
               "out.b_25_34+=isNaN(doc.d.age.b_25_34) ? 0 : doc.d.age.b_25_34;".
               "out.b_35_54+=isNaN(doc.d.age.b_35_54) ? 0 : doc.d.age.b_35_54;".
               "out.o_55+=isNaN(doc.d.age.o_55) ? 0 : doc.d.age.o_55;".
             "}".
           "}";
        break;
      case 'gender_distribution':
        return "function(doc, out){ ".
             "if(doc.d.sex) {".
               "out.m+=isNaN(doc.d.sex.m) ? 0 : doc.d.sex.m;".
               "out.f+=isNaN(doc.d.sex.f) ? 0 : doc.d.sex.f;".
               "out.u+=isNaN(doc.d.sex.u) ? 0 : doc.d.sex.u;".
             "}".
           "}";
        break;
      case 'relationship_status':
        return "function(doc, out){ ".
             "if(doc.d.rel) {".
               "out.singl+=isNaN(doc.d.rel.singl) ? 0 : doc.d.rel.singl;".
               "out.eng+=isNaN(doc.d.rel.eng) ? 0 : doc.d.rel.eng;".
               "out.compl+=isNaN(doc.d.rel.compl) ? 0 : doc.d.rel.compl;".
               "out.mar+=isNaN(doc.d.rel.mar) ? 0 : doc.d.rel.mar;".
               "out.rel+=isNaN(doc.d.rel.rel) ? 0 : doc.d.rel.rel;".
               "out.ior+=isNaN(doc.d.rel.ior) ? 0 : doc.d.rel.ior;".
               "out.wid+=isNaN(doc.d.rel.wid) ? 0 : doc.d.rel.wid;".
               "out.u+=isNaN(doc.d.rel.u) ? 0 : doc.d.rel.u;".
             "}".
           "}";
        break;
      case 'media_penetration_with_clickbacks':
        return "function(doc, out){ ".
             "if(doc.s.facebook) {".
               "out.facebook['contacts']+=isNaN(doc.s.facebook.cnt) ? 0 : doc.s.facebook.cnt;".
               "out.facebook['clickbacks']+=isNaN(doc.s.facebook.cb) ? 0 : doc.s.facebook.cb;".
             "}".
             "if(doc.s.twitter) {".
               "out.twitter['contacts']+=isNaN(doc.s.twitter.cnt) ? 0 : doc.s.twitter.cnt;".
               "out.twitter['clickbacks']+=isNaN(doc.s.twitter.cb) ? 0 : doc.s.twitter.cb;".
             "}".
             "if(doc.s.linkedin) {".
               "out.linkedin['contacts']+=isNaN(doc.s.linkedin.cnt) ? 0 : doc.s.linkedin.cnt;".
               "out.linkedin['clickbacks']+=isNaN(doc.s.linkedin.cb) ? 0 : doc.s.linkedin.cb;".
             "}".
             "if(doc.s.google) {".
               "out.google['contacts']+=isNaN(doc.s.google.cnt) ? 0 : doc.s.google.cnt;".
               "out.google['likes']+=isNaN(doc.s.google.cb) ? 0 : doc.s.google.cb;".
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
<?php


/**
 *
 * > db.visit.update({ host: "kxkxkxkxkxkxkxkkxkx.de", month: "2010-10" }, { $inc : {  "day_1.visits": 1, "day_1.hits": 1}}, { upsert: 1});

 *
 *
 * Enter description here ...
 * @author christian
 *
 */

class VisitTable extends Doctrine_Table
{

  const MONGO_COLLECTION_NAME = 'visit';

  public static function getMongoCollection() {
    return MongoDbConnector::getInstance()->getCollection(sfConfig::get('app_mongodb_database_name_stats'), self::MONGO_COLLECTION_NAME);
  }

  public static function getInstance()
  {
    return Doctrine_Core::getTable('Visit');
  }


  /**
   * Save a given object to our MongoDb
   * @param unknown_type $lObject
   */
  public static function saveObjectToMongoDb($lObject) {
    $lCollection = self::getMongoCollection();
    $lObject = array_filter($lObject);
    $lCollection->save($lObject);
    return $lObject;
  }

  public static function retrieveAllObjects($pLimit = 0, $pOffset = 0) {
    $lCollection = self::getMongoCollection();
    $lMongoCursor = $lCollection->find();
    $lMongoCursor->limit($pLimit)->skip($pOffset);


    return self::hydrateMongoCollectionToObjects($lMongoCursor);
  }

  public static function getObjectsInPeriod($host, $hosst, $dd) {
    $lCollection = self::getMongoCollection();

    $lQueryArray = array();
    $lQueryArray['host'] = new MongoCode("/^a.*/");// "'/^a.*/';


    $lMongoCursor = $lCollection->find($lQueryArray)->limit(5);

    return iterator_to_array($lMongoCursor);

    // return self::hydrateMongoCollectionToObjects($lMongoCursor);
  }

  /**
   * hydrate yiidactivities objects from the extracted collection and return an array
   *
   * @author Christian Schätzle
   * @param unknown_type $pCollection
   * @return array(SocialObject)
   */
  private static function hydrateMongoCollectionToObjects($pCollection) {
    $lObjects = array();
    while($pCollection->hasNext()) {
      $lObjects[] = self::initializeObjectFromCollection($pCollection->getNext());
    }
    return $lObjects;
  }

  /**
   * @author Christian Schätzle
   * @param $pCollection
   */
  public static function initializeObjectFromCollection($pCollection) {
    $lObject = new Visit();
    if ($pCollection) {
      $lObject->fromArray($pCollection);
      return $lObject;
    }
    return null;
  }


  /**
   *
   * get monthly stats from our tracking system
   *
   * @param string $pMonth (format yyyy-mm)
   * @param string $pHost
   * @param int $pPage
   * @param string $pSortCat
   * @param string $pSortOrder
   * @param int $pLimit
   */
  public static function getMonthlyStatistics($pMonth = '', $pHost = null, $pPage = 1, $pSortCat = 'pis_total', $pSortOrder = 'desc', $pLimit = 20) {

    $lCollection = self::getMongoCollection();


    $lQueryArray = self::generateQueryArrayForHostAndMonth($pMonth, $pHost);
    $lSortArray = self::generateSortQuery($pSortCat, $pSortOrder);
    $lObjectsToReturn = array();

    $lMongoCursor = $lCollection->find($lQueryArray);
    $lMongoCursor->sort($lSortArray)->limit($pLimit)->skip(abs($pPage - 1) * $pLimit);
    while($lMongoCursor->hasNext()) {
      $lTempArray = $lMongoCursor->getNext();
      $lObjectsToReturn[] = array_merge(array('pis_total' => 0, 'likes_total' => 0, 'dislikes_total' => 0, 'act_total' => 0), $lTempArray);
    }
    return $lObjectsToReturn;
  }

  /**
   * count matches for this host/month combination for pager
   *
   * @param string $pField
   * @param string $pOrder
   * @author weyandch
   * @return array()
   */
  public static function countHostsForMonth($pMonth = '', $pHost = null) {
    $lQueryArray = self::generateQueryArrayForHostAndMonth($pMonth, $pHost);

    $lCollection = self::getMongoCollection();
    return $lCollection->count($lQueryArray);
  }


  /**
   * generate array for query, respecting mongoDB notation
   *
   * @param string $pMonth
   * @param string $pHost
   * @author weyandch
   * @return array()
   */
  public static function generateQueryArrayForHostAndMonth($pMonth = '', $pHost = null) {
    $lQueryArray = array();
    if ($pHost) {
      $lQueryArray['host'] = new MongoRegex("/.*".$pHost.".*/");
    }
    if ($pMonth != '') {
      $lQueryArray['month'] = $pMonth;
    } else {
      $lQueryArray['month'] = date('Y-m');
    }
    return $lQueryArray;
  }


  /**
   * generate array for sorting, respecting mongoDB notation
   *
   * @param string $pField
   * @param string $pOrder
   * @author weyandch
   * @return array()
   */
  private static function generateSortQuery($pField = 'pis_total', $pOrder = 'asc') {
    $lAllowedFields = array('pis_total', 'likes_total', 'dislikes_total', 'host', 'act_total');

    // invalid input, default order by hostname
    if (!in_array($pField, $lAllowedFields)) {
      return array('host' => 1);
    } else {
      return array($pField => ($pOrder=='asc')?1:-1);
    }

  }

  /**
   *  generates a list of dates to query embedded documents in the mongo stats table
   *
   * @param string $pFormat
   * @param int $pLimit
   * @author weyandch
   * @return array()
   */
  private static function generateDatesForQuery($pFormat = 'day', $pLimit = 31) {
    $lDates = array();
    for($i=1;$i<=$pLimit;$i++) {
      $lDates[] = '"'.$pFormat.'_'.$i.'"';
    }
    return $lDates;
  }

  /**
   *
   * Enter description here ...
   * @deprecated works without m/r
   */
  public static function getMonthStatisticsWithMapreduce() {

    $dates = self::generateDatesForQuery();

    $lMap = new MongoCode("function() {
        var dates = [".implode(', ',$dates)."];
        for(i=0;i<dates.length;i++) {
          if (typeof this.stats[dates[i]] != 'undefined') {
            emit( {host: this.host, month: this.month }, {days: 1, pis: this.stats[dates[i]].pis,  likes: this.stats[dates[i]].likes, dislikes: this.stats[dates[i]].dislikes  });
          }
        };
        };");


    $lReduce = new MongoCode("function(key, vals) {
        var ret = { days: 0, pis: 0, likes: 0, dislikes: 0};
        for (var i in vals) {
            ret.days += vals[i].days;
            ret.pis += vals[i].pis;
            ret.likes += vals[i].likes;
            ret.dislikes += vals[i].dislikes;
        }
        return ret };");


    $lFinalize = new MongoCode("function(who, res) {
    res.total = res.likes + res.dislikes;
    return res;
    };

    ");

    $lVisits = $lDb->command(array(
        "mapreduce" => "visit",
        "map" => $lMap,
        "reduce" => $lReduce,
    //     "sort" => $lSortArray,
    //     "finalize" => $lFinalize,
        "keeptemp" => true,
        "query" => $lQueryArray,
    ));

    $lMongoCursor = $lDb->selectCollection($lVisits['result'])->find();
    $lMongoCursor->sort($lSortArray);
    return $lMongoCursor;
  }

  /**
   * mit group()... lässt sich nicht sortieren!!!
   * evtl. für ermittlung der trends noch brauchbar!
   */
  public static function getHostListOld() {
    $lM = new Mongo('127.0.0.1'); // connect
    $lDb = $lM->selectDB(sfConfig::get("app_mongodb_database_name_stats"));
    $lCollection = $lDb->selectCollection('visit');

    $keys = array('host' => 1);
    $initial = array("cultures" => array(), "pis" => 0, "likes" => 0, "dislikes" => 0 );

    $reduce = "function (obj, output) {
        output.pis += 1;
        if (obj.cult !== undefined) {
          output.cultures[obj.cult] = obj.cult;
        }
        output.likes += isNaN(obj.is_like)?0:1;
        output.dislikes += isNaN(obj.is_dislike)?0:1;
     }";

    // prev.items[obj.uri] = obj.uri;


    $lResult = $lCollection->group($keys, $initial, $reduce);

    foreach ($lResult['retval'] as $element) {

      print_r($element);
      echo "<br/>";
      echo "<br/>";
    };
    /*
     foreach ($lResult as $key => $value) {
     print_r($value);
     echo "<br/>";
     echo "<br/>";
     echo "<br/>";
     }
     //  echo json_encode($lResult['retval']);
     *
     */
    exit();
  }

  public static function countPisForDay($day) {
    $monthGroup = self::groupByMonth($day);
    return array_key_exists(0, $monthGroup) ? $monthGroup[0]['pis_by_day'][strval(date('d', $day))] : 0;
  }

  public static function groupByMonth($date) {
    $lCollection = self::getMongoCollection();

    $keys = array('month' => 1);
    $conds = array('month' => date("Y-m", $date));
    $initial = array("pis_by_day" => array());
    for ($i=0; $i < 31; ++$i) { 
      $initial['pis_by_day'][$i] = 0;
    }

    $reduce = "function (obj, output) {
        if (obj.stats != undefined) {
          for(var el in obj.stats) {
            var index = parseInt(el.match(/\d\d/));
            output.pis_by_day[index] = obj.stats[el]['pis'];
        }
     }}";
     
     $lResult = $lCollection->group($keys, $initial, $reduce, $conds);
     
     return $lResult['retval'];
  }
}

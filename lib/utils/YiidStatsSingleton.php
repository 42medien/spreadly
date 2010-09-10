<?php
class YiidStatsSingleton {

  // new schema
  const MONGO_COLLECTION_NAME_VISIT = 'visit';
  const TYPE_LIKE = 'likes';
  const TYPE_DISLIKE = 'dislikes';


  /**
   * tracks a visit on given url, if the $pLikeType variable is passed an activity is tracked too
   *
   * @param string $pUrl
   * @param string $pLikeType see TYPE_* Constants in this class
   * @author weyandch
   */
  public static function trackVisit($pUrl) {
    $lMongo = new Mongo(LikeSettings::MONGO_HOSTNAME);
    $lCollection = $lMongo->selectCollection(LikeSettings::MONGO_STATS_DATABASENAME, self::MONGO_COLLECTION_NAME_VISIT);

    $pUrl = urldecode($pUrl);

    // data is stored as a tupel of host && month (host => example.com, month => 2010-10)
    $lQueryArray = array();
    $lQueryArray['host'] = parse_url($pUrl, PHP_URL_HOST);
    $lQueryArray['month'] = date('Y-m');

    $lUpdateArray = array( '$inc' => array('stats.day_'.date('d').'.hits' => 1));

    $lCollection->update($lQueryArray, $lUpdateArray, array('upsert' => true));
  }



  /**
   *
   * tracks a count for given $pLikeType
   *
   * @param string $pUrl Full Request URI (http://example.com/page)
   * @param string $pLikeType see TYPE_* Constants in this class
   */
  public static function trackClick($pUrl, $pLikeType) {
    $lCollection = MongoDbConnector::getInstance()->getCollection(sfConfig::get('app_mongodb_database_name_stats'), self::MONGO_COLLECTION_NAME_VISIT);
    $pUrl = urldecode($pUrl);

    // data is stored as a tupel of host && month (host => example.com, month => 2010-10)
    $lQueryArray = array();
    $lQueryArray['host'] = parse_url($pUrl, PHP_URL_HOST);
    $lQueryArray['month'] = date('Y-m');

    if ($pLikeType) {
      // increases the likes/dislikes count
      $lUpdateArray = array( '$inc' => array('stats.day_'.date('d').'.'.$pLikeType => 1));
    }

    $lCollection->update($lQueryArray, $lUpdateArray, array('upsert' => true));
  }

}
?>
<?php
class YiidStatsSingleton {

  // old schema, split into 2 colelctions
  const MONGO_COLLECTION_NAME_VISITS = 'visits';
  const MONGO_COLLECTION_NAME_CLICKS = 'clicks';

  // new schema
  const MONGO_COLLECTION_NAME_VISIT = 'visit';
  const TYPE_LIKE = 'likes';
  const TYPE_DISLIKE = 'dislikes';


  public static function track($pUrl, $pLikeType = null) {
    $lMongo = new Mongo(LikeSettings::MONGO_HOSTNAME);
    $lCollection = $lMongo->selectCollection(LikeSettings::MONGO_STATS_DATABASENAME, self::MONGO_COLLECTION_NAME_VISIT);

    $pUrl = urldecode($pUrl);
    $lQueryArray = array();
    $lQueryArray['host'] = parse_url($pUrl, PHP_URL_HOST);
    $lQueryArray['month'] = date('Y-m');

    $lUpdateArray = array( '$inc' => array('stats.day_'.date('d').'.hits' => 1));
    if ($pLikeType) {
      $lUpdateArray = array( '$inc' => array('stats.day_'.date('d').'.hits' => 1, 'stats.day_'.date('d').'.'.$pLikeType => 1));
    }

    $lCollection->update($lQueryArray, $lUpdateArray, array('upsert' => true));
  }








  /**
   *
   * Track visits/impressions of a given Page
   *
   * @param string $pUri Full Request URI (http://example.com/page)
   * @param string $pType (like|full)
   * @param string $pCulture (de|en)
   * @param int    $pVerb
   */
  public static function trackVisit($pUri, $pUserId = false, $pType) {
    $lMongo = new Mongo(LikeSettings::MONGO_HOSTNAME);
    $lCollection = $lMongo->selectCollection(LikeSettings::MONGO_STATS_DATABASENAME, self::MONGO_COLLECTION_NAME_VISITS);
    $pUri = urldecode($pUri);

    $lVisitArray = array();
    $lVisitArray['uri'] = $pUri;
    if ($pUserId) {
      $lVisitArray['uid'] = $pUserId;
    }
    $lVisitArray['host'] = parse_url($pUri, PHP_URL_HOST);
    $lVisitArray['type'] = $pType;
    $lVisitArray['c'] = time();

    $lCollection->save($lVisitArray);
  }


  /**
   *
   * Track visits/impressions of a given Page
   *
   * @param string $pUri Full Request URI (http://example.com/page)
   * @param string $pType (like|full)
   * @param string $pCulture (de|en)
   * @param int    $pVerb
   */
  public static function trackClick($pUri, $pUserId, $pScore) {
    $lCollection = MongoDbConnector::getInstance()->getCollection(sfConfig::get('app_mongodb_database_name_stats'), self::MONGO_COLLECTION_NAME_CLICKS);
    $pUri = urldecode($pUri);

    $lVisitArray = array();
    $lVisitArray['uri'] = $pUri;
    $lVisitArray['host'] = parse_url($pUri, PHP_URL_HOST);
    $lVisitArray['uid'] = $pUserId;
    $lVisitArray['score'] = $pScore;
    $lVisitArray['cult'] = ''; // $user->getCulture();
    $lVisitArray['c'] = time();

    $lCollection->save($lVisitArray);
  }



}


?>
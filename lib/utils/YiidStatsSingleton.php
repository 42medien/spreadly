<?php
class YiidStatsSingleton {


  const MONGO_COLLECTION_NAME_VISITS = 'visits';
  const MONGO_COLLECTION_NAME_CLICKS = 'clicks';


  /**
   *
   * Track visits/impressions of a given Page
   *
   * @param string $pUri Full Request URI (http://example.com/page)
   * @param string $pType (like|full)
   * @param string $pCulture (de|en)
   * @param int    $pVerb
   */
  public static function trackVisit($pUri, $pUserId = false, $pType, $pCulture, $pVerb) {
    $lMongo = new Mongo(LikeSettings::MONGO_HOSTNAME);
    $lCollection = $lMongo->selectCollection(LikeSettings::MONGO_STATS_DATABASENAME, self::MONGO_COLLECTION_NAME_VISITS);
    $pUri = urldecode($pUri);

    $lVisitArray = array();
    $lVisitArray['uri'] = $pUri;
    if ($pUserId) {
      $lVisitArray['uid'] = $pUserId;
    }
    $lVisitArray['host'] = parse_url($pUri, PHP_URL_HOST);
    $lVisitArray['cult'] = $pCulture;
    $lVisitArray['type'] = $pType;
    $lVisitArray['verb'] = $pVerb;
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
  public static function trackClick($pUri, $pUserId, $pScore, $pVerb) {
    $lCollection = MongoDbConnector::getInstance()->getCollection(sfConfig::get('app_mongodb_database_name_stats'), self::MONGO_COLLECTION_NAME_CLICKS);
    $pUri = urldecode($pUri);

    $lVisitArray = array();
    $lVisitArray['uri'] = $pUri;
    $lVisitArray['host'] = parse_url($pUri, PHP_URL_HOST);
    $lVisitArray['uid'] = $pUserId;
    $lVisitArray['score'] = $pScore;
    $lVisitArray['verb'] = $pVerb;
    $lVisitArray['c'] = time();

    $lCollection->save($lVisitArray);
  }



}


?>
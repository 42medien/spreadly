<?php
class YiidStatsSingleton {


  const MONGO_COLLECTION_NAME_VISITS = 'visits';

  public static function getMongoCollection() {
    return MongoDbConnector::getInstance()->getCollection(sfConfig::get('app_mongodb_visits_database_name'), self::MONGO_COLLECTION_NAME_VISITS);
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
  public static function trackVisit($pUri, $pType, $pCulture, $pVerb) {
    $lCollection = self::getMongoCollection();

    $lVisitArray = array();
    $lVisitArray['uri'] = $pUri;
    $lVisitArray['host'] = parse_url($pUri, PHP_URL_HOST);
    $lVisitArray['cult'] = $pCulture;
    $lVisitArray['type'] = $pType;
    $lVisitArray['verb'] = $pVerb;
    $lVisitArray['c'] = time();

    $lCollection->save($lVisitArray);
  }


}


?>
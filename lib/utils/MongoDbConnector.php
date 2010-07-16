<?php

class MongoDbConnector {

  private static $aInstance = null;
  private static $aMongoConn = null;

  /**
   * singleton logic
   *
   * @return self
   */
  public static function getInstance() {
    if (null === self::$aInstance) {
      self::$aInstance = new MongoDbConnector();
      self::$aMongoConn = new Mongo(sfConfig::get('app_mongodb_host'));
    }
    return self::$aInstance;
  }


  static public function getCollection($pDatabase, $pCollection) {
    return self::$aMongoConn->selectCollection($pDatabase, $pCollection);
  }
}

?>
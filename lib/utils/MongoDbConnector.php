<?php

class MongoDbConnector {

  private static $aInstance = null;
  private static $aMongoConn = null;

  /**
   * singleton logic, connect to mongodb based on host parameter in app.yml
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

  public function getConnection() {
    return self::$aMongoConn;
  }

  public function getDatabase($pDatabase) {
    return self::$aMongoConn->selectDB($pDatabase);
  }


  /**
   * conenct to given collection
   *
   * @param Mongo $pDatabase
   * @param string $pCollection
   * @return MongoCollection
   */
  public function getCollection($pDatabase, $pCollection) {
    return self::$aMongoConn->selectCollection($pDatabase, $pCollection);
  }
}

?>
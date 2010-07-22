<?php


class UserRelationTable extends Doctrine_Table
{

  const MONGO_COLLECTION_NAME = 'user_relation';

  public static function getInstance()
  {
    return Doctrine_Core::getTable('UserRelation');
  }

  public static function getMongoCollection() {
    return MongoDbConnector::getInstance()->getCollection(sfConfig::get('app_mongodb_database_name'), self::MONGO_COLLECTION_NAME);
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





}
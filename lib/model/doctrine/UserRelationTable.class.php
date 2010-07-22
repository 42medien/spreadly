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


  /**
   * update onlineidentities owned by a given user
   * Enter description here ...
   * @param unknown_type $pUserId
   * @param unknown_type $pIdentities
   */
  public static function updateOwnedIdentities($pUserId, $pIdentities) {
    $lCollection = self::getMongoCollection();

    if (!is_array($pIdentities)) {
      $pIdentities = array($pIdentities);
    }

    $lQueryArray = array('$addToSet' => array('owned_oi' => array('$each' => $pIdentities)));
    return $lCollection->update(array('user_id' => $pUserId), $lQueryArray);
  }


  /**
   * retrieve relation data for a given user
   * @param $pUserId
   */
  public static function retrieveUserRelations($pUserId) {
    $lCollection = self::getMongoCollection();
    return self::initializeObjectFromCollection($lCollection->findOne(array("user_id" => $pUserId )));
  }



  /**
   * creates object from a given MongoDb Collection
   * @param unknown_type $pCollection
   */
  public static function initializeObjectFromCollection($pCollection) {
    $lObject = new UserRelation();
    if ($pCollection) {
      $lObject->fromArray($pCollection);
      return $lObject;
    }
    return null;
  }


}
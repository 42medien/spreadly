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
    return $lCollection->update(array('user_id' => $pUserId), $lQueryArray, array('upsert' => true));
  }

  /**
   * add OI's of a users contacts
   *
   * @param $pUserId
   * @param $pIdentities
   */
  public static function updateContactIdentities($pUserId, $pIdentityIds, $pContactUserIds) {
    $lCollection = self::getMongoCollection();

    if (!is_array($pContactUserIds)) {
      $pContactUserIds = array($pContactUserIds);
    }
    if (!is_array($pIdentityIds)) {
      $pIdentityIds = array($pIdentityIds);
    }

    $lQueryArray = array('$addToSet' => array('contacts_oi' => array('$each' => array_filter($pIdentityIds)),
                                              'contact_uid' => array('$each' => array_filter($pContactUserIds))
                                              )
                         );

    return $lCollection->update(array('user_id' => $pUserId), $lQueryArray, array('upsert' => true));
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
   * returns an array of oi's for given friendid // userid
   *
   * @param int $pUserId
   * @param int $pFriendId
   * @author weyandch
   */
  public static function getRelevantOnlineIdentitys($pUserId, $pFriendId) {
    $pOiArray = array();
    if (is_null($pFriendId)) {
      $pOiArray = self::retrieveUserRelations($pUserId)->getContactsOi();
    } else {
      $pOiArray = self::retrieveUserRelations($pFriendId)->getOwnedOi();
    }
  print_r($pOiArray);die();
  //  $pOiArray = array_merge($pOiArray, self::retrieveUserRelations($pUserId)->getOwnedOi());

    return $pOiArray;
  }




  /**
   * creates object from a given MongoDb Collection
   * @param unknown_type $pCollection
   */
  public static function initializeObjectFromCollection($pCollection) {
    $lObject = new UserRelation();
    if ($pCollection) {
      $lObject->fromArray($pCollection);
    }
    return $lObject;
  }


  public static function doShit($pUserId) {
    $lUserId = $pUserId;

    $lUiCons = UserIdentityConTable::getOnlineIdentityIdsForUser($lUserId);

    UserRelationTable::updateOwnedIdentities($lUserId, $lUiCons);

    foreach ($lUiCons as $lOiId) {

      $lUsersConnected = array();
      $lOiIds = OnlineIdentityConTable::getIdentitysConnectedToOi($lOiId);
      foreach ($lOiIds as $lOi) {
        $lUsersConnected = array_merge($lUsersConnected, UserIdentityConTable::getUserIdsConnectedToOnlineIdentityId($lOi));
      }

      UserRelationTable::updateContactIdentities($lUserId, $lOiIds, $lUsersConnected);
    }


  }

}
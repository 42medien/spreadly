<?php


class SocialObjectTable extends Doctrine_Table
{
  const MONGO_COLLECTION_NAME = 'social_object';

  public static function getInstance()
  {
    return Doctrine_Core::getTable('SocialObject');
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
   * Updates an object in Mongo, respecting MongoDB's Syntax to manipulate stored objects
   *
   * @see  http://www.mongodb.org/display/DOCS/Updating
   *
   * @param Array() $pIdentifier
   * @param Array() $pManipualtior
   */
  public static function updateObjectInMongoDb($pIdentifier, $pManipualtior) {
    $lCollection = self::getMongoCollection();
    $lCollection->update($pIdentifier, $pManipualtior);
  }


  /**
   * create a new social object and fills with basic inforamtion given by the executed widget
   *
   * @author weyandch
   * @param $pUrl
   * @param $pLongUrl
   * @param $pTitle
   * @param $pDescription
   * @return unknown_type
   */
  public static function createSocialObject($pUrl, $pLongUrl = null, $pTitle = null, $pDescription = null, $pImage = null) {
    if ($pLongUrl) {
      $lAliasArray = array(md5($pUrl), md5($pLongUrl));
    } else {
      $lAliasArray = array( md5($pUrl));
    }
    $lSocialObject = new SocialObject();
    $lSocialObject->setUrl($pUrl);
    $lSocialObject->setAlias($lAliasArray);
    $lSocialObject->setTitle(utf8_encode($pTitle));
    $lSocialObject->setDescription(utf8_encode($pDescription));
    $lSocialObject->setThumbnailUrl($pImage);
    $lSocialObject->save();
    return $lSocialObject;
  }


  public static function retrieveHotObjets($pUserId, $pFriendId = null, $pCommunityId = null, $pRange = 7, $pPage = 1, $pLimit = 30)  {
    $lCollection = self::getMongoCollection();
    $lRelevantOis = self::getRelevantOnlineIdentitysForQuery($pUserId, $pFriendId);
    $lQueryArray = self::initializeBasicFilterQuery($lRelevantOis, $pCommunityId, $pRange);

    $lResults = $lCollection->find($lQueryArray);
    $lResults->sort(array('l_cnt' => -1));

    return self::hydrateMongoCollectionToObjects($lResults);
  }


  public static function retrieveFlopObjects($pUserId, $pFriendId = null, $pCommunityId = null, $pRange = 7, $pPage = 1, $pLimit = 30) {
    $lCollection = self::getMongoCollection();
    $lRelevantOis = self::getRelevantOnlineIdentitysForQuery($pUserId, $pFriendId);
    $lQueryArray = self::initializeBasicFilterQuery($lRelevantOis, $pCommunityId, $pRange);

    $lResults = $lCollection->find($lQueryArray);

    $lResults->sort(array('d_cnt' => -1));

    return self::hydrateMongoCollectionToObjects($lResults);
  }



  public static function getRelevantOnlineIdentitysForQuery($pUserId, $pFriendId) {
    $pOiArray = array();
    if (is_null($pFriendId)) {
      $pOiArray = UserRelationTable::retrieveUserRelations($pUserId)->getContactsOi();
    } else {
      $pOiArray = UserRelationTable::retrieveUserRelations($pFriendId)->getOwnedOi();
    }

    return $pOiArray?$pOiArray:array();
  }

  /**
   * generates common filter elements we need in each query
   *
   * @param array() $pOis
   * @param int $pCommunityId
   * @param int $pRange
   * @return array()
   */
  private static function initializeBasicFilterQuery($pOis = null, $pCommunityId = null, $pRange = 7) {
    $lQueryArray = array();
    $lQueryArray['u'] = array('$gte' => strtotime('-'.$pRange. ' days'));
    $lQueryArray['oiids'] = array('$in' => $pOis);
    if ($pCommunityId) {
      $lQueryArray['cids'] = array('$in' => array($pCommunityId));
    }

    return $lQueryArray;
  }


  /**
   * hydrate social objects from the extracted collection and return an array
   *
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
   * retrieve SocialObject from MongoDb by its ID
   *
   * @author Christian Weyand
   * @param $pId
   * @return unknown_type
   */
  public static function retrieveByPK($pId, PropelPDO $con = null){
    $lCollection = self::getMongoCollection();
    return self::initializeObjectFromCollection($lCollection->findOne(array("_id" => new MongoId($pId) )));
  }

  /**
   *
   * @author weyandch
   * @param $pIds
   * @param $con
   * @return unknown_type
   */
  public static function retrieveByPKs($pIds, PropelPDO $con = null){
    $lCollection = self::getMongoCollection();
    $lObjects = array();
    foreach ($pIds as $pId) {
      $lObjects[] = self::initializeObjectFromCollection($lCollection->findOne(array("_id" => new MongoId($pId)) ));
    }
    return $lObjects;
  }

  /**
   *
   * @author weyandch
   * @param $pUrl
   * @return unknown_type
   */
  public static function retrieveByAliasUrl($pUrl) {
    return self::retrieveByAliasHash(md5($pUrl));
  }


  /**
   * @author weyandch
   * @param $pUrlHash
   * @return unknown_type
   */
  public static function retrieveByAliasHash($pUrlHash) {
    $lCollection = self::getMongoCollection();
    return self::initializeObjectFromCollection($lCollection->findOne(array("alias" => array('$in' => array($pUrlHash)) )));
  }


  /**
   * @author weyandch
   * @param $pUrl
   * @return unknown_type
   */
  public static function retrieveByUrl($pUrl) {
    return self::retrieveByUrlHash(md5($pUrl));
  }

  /**
   * @author weyandch
   * @param $pUrlHash
   * @return unknown_type
   */
  public static function retrieveByUrlHash($pUrlHash) {
    $lCollection = self::getMongoCollection();
    return self::initializeObjectFromCollection($lCollection->findOne(array("url_hash" => $pUrlHash) ));
  }


  /**
   * creates object from a given MongoDb Collection
   * @param unknown_type $pCollection
   */
  public static function initializeObjectFromCollection($pCollection) {
    $lObject = new SocialObject();
    if ($pCollection) {
      $lObject->fromArray($pCollection);
      return $lObject;
    }
    return null;
  }


  public static function retrieveAll() {
    $lCollection = self::getMongoCollection();
    return $lResults = $lCollection->find();
  }

  public static function doCountAll() {
    $lCollection = self::getMongoCollection();
    return $lCollection->count();
  }
}
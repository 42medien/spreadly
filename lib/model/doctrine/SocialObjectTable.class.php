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
    $lSocialObject->setAlias(implode(',', $lAliasArray));
    $lSocialObject->setTitle(utf8_encode($pTitle));
    $lSocialObject->setDescription(utf8_encode($pDescription));
    $lSocialObject->setThumbnailUrl($pImage);
    $lSocialObject->save();
    return $lSocialObject;
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


  public static function initializeObjectFromCollection($pCollection) {
    $lObject = new SocialObject();
    if ($pCollection) {
      $lObject->fromArray($pCollection, BasePeer::TYPE_FIELDNAME);
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
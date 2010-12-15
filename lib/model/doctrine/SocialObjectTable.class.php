<?php
class SocialObjectTable extends Doctrine_Table
{
  const MONGO_COLLECTION_NAME = 'social_object';

  const ENRICHED_TYPE_NONE = 0;
  const ENRICHED_TYPE_OBJECTPARSER = 1;

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
    $lCollection->update($pIdentifier, $pManipualtior, array('upsert' => true));
  }



  /**
   * initializes a basic social object for a given url
   *
   * @param string $pUrl
   * @return SocialObject
   */
  public static function initializeObjectFromUrl($pUrl, $pEnriched = 0) {
    $lCollection = self::getMongoCollection();
    $pUrl = UrlUtils::cleanupHostAndUri($pUrl);

    // check if this url has some redirects
    $pLongUrl = UrlUtils::shortUrlExpander($pUrl);

    if ($pLongUrl === false) {
      return false;
    }
    elseif($pLongUrl && UrlUtils::isUrlValid($pLongUrl)) {
      $pLongUrl = UrlUtils::cleanupHostAndUri($pLongUrl);
    }


    $pUrlHash = md5(UrlUtils::skipTrailingSlash($pUrl));
    $pLongUrlHash = md5(UrlUtils::skipTrailingSlash($pLongUrl));

    if ($pLongUrl && ($pLongUrl != $pUrl)) {
      $lSocialObject = self::retrieveByAliasUrl($pLongUrl);
      if ($lSocialObject) {  // gibt's schon unter $longUrl -> also $pUrl hinzufügen
        $lSocialObject->addAlias($pUrlHash);
        return true;
      } else {
        // get it parsed baby!
        AmazonSQSUtils::pushToQuque('SocialObjectParser', urlencode($pUrl));
        return $lCollection->update(array('url_hash' => $pUrlHash), array('$set' => array('url' => $pUrl, 'c' => time(), 'enriched' => $pEnriched), '$addToSet' => array('alias' => array('$each' => array($pUrlHash, $pLongUrlHash)))), array('upsert' => true, 'atomic' => true));
      }
    } else {
      // get it parsed baby!
      AmazonSQSUtils::pushToQuque('SocialObjectParser', urlencode($pUrl));
      return $lCollection->update(array('url_hash' => $pUrlHash), array('$set' => array('url' => $pUrl, 'c' => time(), 'enriched' => $pEnriched), '$addToSet' => array('alias' => $pUrlHash)), array('upsert' => true, 'atomic' => true));
    }
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
    if ($pLongUrl && $pLongUrl != $pUrl) {
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


  public static function retrieveHotObjets($pUserId, $pFriendId = null, $pCommunityId = null, $pRange = 30, $pPage = 1, $pLimit = 30)  {
    $lCollection = self::getMongoCollection();
    $lRelevantOis = OnlineIdentityTable::getRelevantOnlineIdentityIdsForQuery($pUserId, $pFriendId);
    $lQueryArray = self::initializeBasicFilterQuery($lRelevantOis, $pCommunityId, $pRange);
    $lQueryArray['l_cnt'] = array('$gt' => 0);

    $lResults = $lCollection->find($lQueryArray);
    $lResults->sort(array('l_cnt' => -1));
    $lResults->limit($pLimit)->skip(($pPage - 1) * $pLimit);

    return self::hydrateMongoCollectionToObjects($lResults);
  }


  public static function retrieveFlopObjects($pUserId, $pFriendId = null, $pCommunityId = null, $pRange = 30, $pPage = 1, $pLimit = 30) {
    $lCollection = self::getMongoCollection();
    $lRelevantOis = OnlineIdentityTable::getRelevantOnlineIdentityIdsForQuery($pUserId, $pFriendId);
    $lQueryArray = self::initializeBasicFilterQuery($lRelevantOis, $pCommunityId, $pRange);
    $lQueryArray['d_cnt'] = array('$gt' => 0);

    $lResults = $lCollection->find($lQueryArray);

    $lResults->sort(array('d_cnt' => -1));
    $lResults->limit($pLimit)->skip(($pPage - 1) * $pLimit);

    return self::hydrateMongoCollectionToObjects($lResults);
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
    if ($pRange > 0) {
      $lQueryArray['u'] = array('$gte' => strtotime('-'.$pRange. ' days'));
    }
    $lQueryArray['oiids'] = array('$in' => $pOis);
    if ($pCommunityId) {
      $lQueryArray['cids'] = array('$in' => array($pCommunityId));
    }

    return $lQueryArray;
  }


  /**
   *
   * returns an array with userid's of your friends, who acted on a given social object
   *
   * @param string $pSocialObjectId
   * @param int $pUserId
   * @return array()
   * @author weyandch
   */
  public static function getFriendIdsForSocialObject($pSocialObjectId, $pUserId) {
    $lSocialObject = self::retrieveByPK($pSocialObjectId);
    $lConnectedUsers = IdentityMemcacheLayer::retrieveContactUserIdsByUserId($pUserId);

    $lFriendsActive = array();
    if ($lSocialObject && $lConnectedUsers) {
      $lFriendsActive = array_intersect($lSocialObject->getUids(), $lConnectedUsers);
    }
    return $lFriendsActive;
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
  public static function retrieveByPK($pId){
    $lCollection = self::getMongoCollection();
    return self::initializeObjectFromCollection($lCollection->findOne(array("_id" => new MongoId($pId) )));
  }

  /**
   *
   * @author weyandch
   * @param $pIds
   * @return array
   */
  public static function retrieveByPKs($pIds){
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
    return self::retrieveByAliasHash(md5(UrlUtils::skipTrailingSlash($pUrl)));
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
   * creates object from a given MongoDb Collection
   * @param unknown_type $pCollection
   */
  public static function initializeObjectFromCollection($pCollection) {
    $lObject = new SocialObject();
    if ($pCollection) {
      $lObject->fromArray($pCollection);
      $lObject->setId($pCollection['_id']."");
      return $lObject;
    }
    return null;
  }


  public static function retrieveAll() {
    $lCollection = self::getMongoCollection();
    return self::hydrateMongoCollectionToObjects($lCollection->find());
  }

  public static function doCountAll() {
    $lCollection = self::getMongoCollection();
    return $lCollection->count();
  }
}
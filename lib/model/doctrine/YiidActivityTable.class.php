<?php
class YiidActivityTable extends Doctrine_Table {
  const ACTIVITY_VOTE_POSITIVE = 1;
  const ACTIVITY_VOTE_NEGATIVE = -1;

  const MONGO_COLLECTION_NAME = 'yiid_activity';

  public static $aTypes = array("like","pro","recommend","visit","nice","buy","rsvp");

  public static function getInstance() {
    return Doctrine_Core::getTable('YiidActivity');
  }

  public static function getMongoCollection() {
    return MongoDbConnector::getInstance()->getCollection(sfConfig::get('app_mongodb_database_name'), self::MONGO_COLLECTION_NAME);
  }

  /**
   * returns the latest activities of a user (desc order by date)
   *
   * @author Matthias Pfefferle
   * @param int $pUserId
   * @param int $pLimit default = 10
   * @return array
   */
  public static function retrieveLatestByUserId($pUserId, $pLimit = 10) {
    $lCollection = self::getMongoCollection();

    $lResults = $lCollection->find(array(
      "u_id" => intval($pUserId),
      "d_id" => array('$exists' => false)
    ));

    $lResults->sort(array('c' => -1));
    $lResults->limit($pLimit);

    return self::hydrateMongoCollectionToObjects($lResults);
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
  public static function updateObjectInMongoDb($pIdentifier, $pManipulator) {
    $lCollection = self::getMongoCollection();
    $lCollection->update($pIdentifier, $pManipulator, array('upsert' => true));
  }

  /**
   * retrieve data saved with this sess_id
   *
   * @author weyandch
   * @param $pSessionId
   * @return unknown_type
   */
  public static function getTemporaryData($pSessionId) {
    $lPersist = PersistentVariableTable::retrieveByName('widgetauth_'.$pSessionId);
    if ($lPersist) {
      $lReturn = unserialize($lPersist->getValue());
      $lPersist->delete();
      return $lReturn;
    } else {
      return null;
    }
  }

  /**
   *
   * @author Christian Weyand
   * @param int $pSocialObjectId
   * @param array $pOnlineIdentitys
   * @return array
   */
  public static function retrieveActionOnObjectById($pSocialObjectId, $pUserId, $pDeal = null) {
    $lCollection = self::getMongoCollection();

    // get yiid-activity and factor a deal
    $lQuery = $lCollection->findOne(array(
      "so_id" => new MongoId($pSocialObjectId.""),
      "u_id" => intval($pUserId),
      "d_id" => ($pDeal ? intval($pDeal->getId()) : array('$exists' => false))
    ));

    return self::initializeObjectFromCollection($lQuery);
  }

  /**
   * Counts the Likes or dislikes per User
   * @author hannes
   * @param int $pUserId the user id
   * @param boolean $pIsLike whether you want likes or dislikes
   * @return count of activity
   */
  public static function retrieveActivityCountByUserId($pUserId, $pIsLike=true) {
    $lCollection = self::getMongoCollection();

    $lQuery = $lCollection->count(array(
      "u_id" => intval($pUserId),
      "score" => $pIsLike ? 1 : -1
    ));

    return $lQuery;
  }

  /**
   * Gets the activties that were deal participations for a User
   * @author hannes
   * @param int $pUserId the user id
   * @return activties that were deal participations
   */
  public static function retrieveDealActivitiesByUserId($pUserId) {
    $lCollection = self::getMongoCollection();

    $lResults = $lCollection->find(array(
      "u_id" => intval($pUserId),
      "d_id" => array('$exists' => true)
    ));

    $lResults->sort(array('c' => -1));

    return self::hydrateMongoCollectionToObjects($lResults);
  }

  public static function retrieveLatestActivitiesByContacts($pUserId, $pFriendId = null, $pCommunityId = null, $pRangeDays = 30, $pOffset = 10, $pLimit = 1) {
    $lCollection = self::getMongoCollection();

    $lRelevantOis = OnlineIdentityTable::getRelevantOnlineIdentityIdsForQuery($pUserId, $pFriendId);

    // we don't have contacts, so we MUST NOT use an $in Query on mongodb
    //   if (empty($lRelevantOis)) {
    //    return array();
    //   }
    $lQueryArray = array();
    $lQueryArray['oiids'] = array('$in' => $lRelevantOis);
    if ($pCommunityId) {
      $lQueryArray['cids'] = array('$in' => array($pCommunityId));
    }
    if ($pRangeDays > 0) {
      $lQueryArray['u'] = array('$gte' => strtotime('-'.$pRangeDays. ' days'));
    }

    $lResults = $lCollection->find($lQueryArray);
    $lResults->sort(array('c' => -1));
    $lResults->limit($pLimit)->skip(($pOffset - 1) * $pLimit);
    return self::hydrateMongoCollectionToObjects($lResults);
  }

  /**
   * retrieve YiidActivies for a given SovialObject MongoDbID
   *
   * @author Christian Weyand
   * @param int $pUserId
   * @param int $pId
   * @param string $pCase
   * @param int $pLimit
   * @param int $pPage
   * @return array
   */
  public static function retrieveByYiidActivityId($pUserId, $pId, $pCase, $pLimit = 10, $pOffset = 1){
    $lCollection = self::getMongoCollection();
    $lRelevantOis = OnlineIdentityTable::getRelevantOnlineIdentityIdsForQuery($pUserId, null);
    $lQueryArray = array();
    // filters friends
    //$lQueryArray['oiids'] = array('$in' => $lRelevantOis);
    $lQueryArray['so_id'] = new MongoId($pId);
    $lQueryArray = array_merge($lQueryArray, self::addCaseQuery($pCase));

    $lResults = $lCollection->find($lQueryArray);
    $lResults->sort(array('c' => -1));

    $lResults->limit($pLimit)->skip(($pOffset - 1) * $pLimit);

    return self::hydrateMongoCollectionToObjects($lResults);
  }



  /**
   * transforms $pCase from action into score values for MongoDB
   *
   * @author Christian Weyandch
   *
   * @param string $pCase
   * @return int
   */
  public static function addCaseQuery($pCase) {
    if ($pCase == 'hot') {
      return array('score' => 1);
    } elseif ($pCase == 'not') {
      return array('score' => -1);
    }
    return array();
  }

  /**
   * check if the given verb is supported in the current version
   *
   * @param string $pVerb
   * @return boolean
   */
  public static function isVerbSupported($pVerb) {
    return in_array($pVerb, sfConfig::get('app_likewidget_types'));
  }

  /**
   *
   * @author Christian Weyand
   * @param $pCollection
   * @return unknown_type
   */
  public static function initializeObjectFromCollection($pCollection) {
    $lObject = new YiidActivity();
    if ($pCollection) {
      $lObject->fromArray($pCollection);
      $lObject->setId($pCollection['_id']."");
      return $lObject;
    }
    return null;
  }

  /**
   * hydrate yiidactivities objects from the extracted collection and return an array
   *
   * @param unknown_type $pCollection
   * @return array <SocialObject>
   */
  private static function hydrateMongoCollectionToObjects($pCollection) {
    $lObjects = array();
    while($pCollection->hasNext()) {

      $lObjects[] = self::initializeObjectFromCollection($pCollection->getNext());
    }
    return $lObjects;
  }

  public static function retrieveAllObjects($pLimit = 0, $pOffset = 0) {
    $lCollection = self::getMongoCollection();
    $lMongoCursor = $lCollection->find();
    $lMongoCursor->limit($pLimit)->skip($pOffset);

    return self::hydrateMongoCollectionToObjects($lMongoCursor);
  }

  public static function getByDealIdAndUserId($pDealId, $pUserId) {
    $lCollection = self::getMongoCollection();

    $lQuery = $lCollection->findOne(array("u_id" => (int)$pUserId,
                                          "d_id" => (int)$pDealId
                                          ));

    return self::initializeObjectFromCollection($lQuery);
  }

  /**
   * returns an array of deals by deal-id, user-id and url
   *
   * @param int $pDealId
   * @param int $pUserId
   * @param string $pUrl
   * @return mixed
   */
  public static function getByDealIdAndUserIdAndUrl($pDealId, $pUserId, $pUrl) {
    $lCollection = self::getMongoCollection();

    $pUrl = UrlUtils::cleanupHostAndUri($pUrl);
    $lSocialObject = SocialObjectTable::retrieveByAliasUrl($pUrl);

    if ($lSocialObject) {
      $lQuery = $lCollection->findOne(array("u_id" => (int)$pUserId,
                                            "d_id" => (int)$pDealId,
                                            "so_id" => new MongoId($lSocialObject->getId()."")
                                           ));

      return self::initializeObjectFromCollection($lQuery);
    } else {
      return null;
    }
  }


  public static function retrieveByUserIdAndUrl($pUserId, $pUrl, $pIgnoreDeals=true) {
    $lCollection = self::getMongoCollection();

    $pUrl = UrlUtils::cleanupHostAndUri($pUrl);
    $lSocialObject = SocialObjectTable::retrieveByAliasUrl($pUrl);
    $lCond = array("u_id" => (int)$pUserId, "so_id" => new MongoId($lSocialObject->getId().""));

    if($pIgnoreDeals) {
      $lCond["d_id"] = array('$exists' => false);
    }

    if ($lSocialObject) {
      $lQuery = $lCollection->findOne($lCond);

      return self::initializeObjectFromCollection($lQuery);
    } else {
      return null;
    }
  }
  /**
   * normalize the tag-string
   *
   * @param string $tags
   * @return array
   */
  public static function normalizeTags($pTags) {
    $lTags = urldecode($pTags);
    $lTags = explode(",", $lTags);

    if (is_array($lTags)) {
      $lTagArray = array();
      foreach ($lTags as $key => $value) {
        $lTagArray[$key] = trim($value);
      }

      $lTagArray = array_unique($lTagArray);

      return $lTagArray;
    } else {
      return null;
    }
  }

  public static function retrieveById($pId) {
    $lCollection = self::getMongoCollection();
    $lQuery = $lCollection->findOne(array(
      "_id" => new MongoId($pId."")
    ));
    return self::initializeObjectFromCollection($lQuery);
  }

}
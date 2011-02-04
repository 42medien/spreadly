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
   * save the like/dislike
   *
   * @author Matthias Pfefferle
   *
   * @param int $pUserId
   * @param string $pUrl
   * @param array $pGivenOnlineIdentitys
   * @param int $pScore
   * @param string $pVerb
   * @param string $pTitle
   * @param string $pDescription
   * @param string $pPhoto
   * @param string $pClickback
   * @param string $pTags
   * @return YiidActivity
   */
  public static function saveLikeActivitys($pUserId,
                                           $pUrl,
                                           $pGivenOnlineIdentitys = array(),
                                           $pScore = self::ACTIVITY_VOTE_POSITIVE,
                                           $pVerb = 'like',
                                           $pTitle = null,
                                           $pDescription = null,
                                           $pPhoto = null,
                                           $pClickback = null,
                                           $pTags = null
                                          ) {

    if (!self::isVerbSupported($pVerb)) {
      return false;
    }

    $lVerifiedOnlineIdentitys = array();
    $pClickback = urldecode($pClickback);
    $pTitle = StringUtils::cleanupString($pTitle);
    $pDescription = StringUtils::cleanupString($pDescription);

    // array of services we're sharing to
    $lServices = array();

    $pUrl = UrlUtils::cleanupHostAndUri($pUrl);
    $lDeal = DealTable::getActiveDealByHostAndUserId($pUrl, $pUserId);

    $lSocialObject = SocialObjectTable::retrieveOrCreate($pUrl, $pTitle, $pDescription, $pPhoto);
    
    if (!$lSocialObject || self::retrieveActionOnObjectById($lSocialObject->getId(), $pUserId, $lDeal)) {
      return false;
    }
    
    $lVerifiedOIs = OnlineIdentityTable::retrieveVerified($pUserId, $pGivenOnlineIdentitys);
    
    // save yiid activity
    $lActivity = self::saveActivity($lSocialObject, $pUserId, $lVerifiedOIs, $pScore, $pVerb, $pClickback, $lDeal, $pTags);
    if (sfConfig::get('sf_environment') != 'dev') {
      // send messages to all services
      foreach ($lOnlineIdentitys as $lIdentity) {
        $lQueryChar = parse_url($pUrl, PHP_URL_QUERY) ? '&' : '?';
        $pPostUrl = $pUrl.$lQueryChar.'yiidit='.$lIdentity->getCommunity()->getCommunity().'.'.$lActivity->getId();
        $lStatus = $lIdentity->sendStatusMessage($pPostUrl, $pVerb, $pScore, $pTitle, $pDescription, $pPhoto);
      }
    }
    
    if ($lActivity->getOiids()) {
      $lSocialObject = SocialObjectTable::retrieveByAliasUrl($pUrl);
      $lSocialObject->updateObjectOnLikeActivity($pUserId, $lActivity->getOiids(), $pUrl, $pScore, $lServices);
      UserTable::updateLatestActivityForUser($pUserId, time());
    }

    // notification
    $lUser = UserTable::getInstance()->retrieveByPk($pUserId);
    StatsFeeder::feed($lActivity, $lUser, $lSocialObject);

    return $lActivity;
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
   * generates a new yiid-activity
   *
   * @author Matthias Pfefferle
   *
   * @param SocialObject $pSocialObject
   * @param string $pUrl
   * @param int $pUserId
   * @param array $pOnlineIdentitys
   * @param int $pServicesId
   * @param int $pScore
   * @param string $pVerb
   * @param mixed $pClickback
   * @param Deal $pDeal
   * @param string $pTags comma separated
   * @return YiidActivity
   */
  private static function saveActivity($pSocialObject,
                                      $pUserId,
                                      $pOnlineIdentitys,
                                      $pScore,
                                      $pVerb,
                                      $pClickback = null,
                                      $pDeal = null,
                                      $pTags = null
                                     ) {

    $lActivity = new YiidActivity();
    $lActivity->setUId($pUserId);
    $lActivity->setSoId($pSocialObject->getId());
    $lActivity->setUrl($pSocialObject->getUrl());
    $lActivity->setUrlHash(md5(UrlUtils::skipTrailingSlash($pSocialObject->getUrl())));
    $lActivity->setScore($pScore);
    $lActivity->setVerb($pVerb);
    $lActivity->setC(time());

    
    $lOIIds = array();
    $lCIds = array();
    foreach ($pOnlineIdentitys as $lOI) {
      $lOIIds[] = $lOI->getId();
      $lCIds[] = $lOI->getCommunityId();
    }
    
    $lActivity->setOiids($lOIIds);
    $lActivity->setCids($lCIds);

    // set tags
    if ($pTags) {
      $pTags = self::normalizeTags($pTags);
      if (is_array($pTags) && !empty($pTags)) {
        $lActivity->setTags($pTags);
      }
    }

    // sets the deal-id if it's not empty
    if ($pDeal && $pDeal->isActive()) {
      if ($lCoupon = $pDeal->popCoupon()) {
        $lActivity->setDId($pDeal->getId());
        $lActivity->setCCode($lCoupon);
      }
    }

    // set clickback if exists
    if ($pClickback) {
      $lClickback = explode('.', $pClickback);
      if (count($lClickback) > 1) {
        $lActivity->setCbService($lClickback[0]);
        $lActivity->setCbReferer($lClickback[1]);
      }
    }
    $lActivity->save();

    return $lActivity;
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
   *
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
}
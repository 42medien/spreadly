<?php


class YiidActivityTable extends Doctrine_Table
{
  const ACTIVITY_VOTE_POSITIVE = 1;
  const ACTIVITY_VOTE_NEGATIVE = -1;

  const MONGO_COLLECTION_NAME = 'yiid_activity';

  public static function getInstance()
  {
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





  public static function saveLikeActivitys($pUserId,
                                            $pUrl,
                                            $pOwnedOnlineIdentitys = array(),
                                            $pGivenOnlineIdentitys = array(),
                                            $pScore = self::ACTIVITY_TYPE_LIKE,
                                            $pVerb = 'like',
                                            $pTitle = null,
                                            $pDescription = null,
                                            $pPhoto = null) {


    $lVerifiedOnlineIdentitys = array();
    $pTitle = utf8_encode(urldecode($pTitle));
    $pDescription = utf8_encode(urldecode($pDescription));
    $pPhoto = utf8_encode(urldecode($pPhoto));

    // array of services we're sharing to
    $lServices = array();

    if (!self::isVerbSupported($pVerb)) {
      return false;
    }
    $pUrl = UrlUtils::cleanupHostAndUri($pUrl);
    $lSocialObject = self::retrieveSocialObjectByAliasUrl($pUrl);
    if (!$lSocialObject) {
      // check redirects for link shortenes
      $pLongUrl = UrlUtils::shortUrlExpander($pUrl);

      if(!$pLongUrl || !UrlUtils::isUrlValid($pLongUrl)) {
        return false;
      }
      $pLongUrl = UrlUtils::cleanupHostAndUri($pLongUrl);

      if ($pLongUrl != $pUrl) {
        $lSocialObject = self::retrieveSocialObjectByAliasUrl($pLongUrl);
        if ($lSocialObject) {  // gibt's schon unter $longUrl -> also $pUrl hinzufügen
          $lSocialObject->addAlias($pUrl);
        } else {
          $lSocialObject =  SocialObjectTable::createSocialObject($pUrl, $pLongUrl, $pTitle, $pDescription, $pPhoto);
        }
      } else {
        $lSocialObject = SocialObjectTable::createSocialObject($pUrl, null, $pTitle, $pDescription, $pPhoto);
      }
    } else {
      // unless we got an freaky object parser we check on updates on every action on an object
      $lSocialObject->updateObjectMasterData($pTitle, $pDescription, $pPhoto);

    }

    if (!self::isActionOnObjectAllowed($lSocialObject->getId(), $pUserId)) {
      return false;
    }

    foreach ($pGivenOnlineIdentitys as $lIdentityId) {
      if (in_array($lIdentityId, $pOwnedOnlineIdentitys)) {
        $lVerifiedOnlineIdentityIds[]= $lIdentityId;

        $senderOi = OnlineIdentityTable::getInstance()->find($lIdentityId);
        $lServices[] = $senderOi->getCommunityId();
        //   $lStatus = $senderOi->sendStatusMessage($pUrl, $pVerb, $pScore, utf8_decode($pTitle), utf8_decode($pDescription), $pPhoto);
        sfContext::getInstance()->getLogger()->debug("{YiidActivityPeer}{saveLikeActivitys} Status Message: " . print_r($lStatus, true));
      }
      else {
      }
    }

    if (!empty($lVerifiedOnlineIdentityIds)) {
      self::saveActivity($lSocialObject, $pUrl, $pUserId, $lVerifiedOnlineIdentityIds, $lServices, $pScore, $pVerb);
      $lSocialObject->updateObjectOnLikeActivity($lVerifiedOnlineIdentityIds, $pUrl, $pScore, $lServices);
      YiidStatsSingleton::trackClick(urldecode($pUrl), $pUserId, $pScore, $pVerb);
    }
    return true;
  }




  public static function storeTemporary($pSessionId,
  $pUrl,
  $pOwnedOnlineIdentitys = array(),
  $pGivenOnlineIdentitys = array(),
  $pScore = self::ACTIVITY_TYPE_LIKE,
  $pVerb = 'like',
  $pTitle = null,
  $pDescription = null,
  $pPhoto = null) {

    $lStorageArray = array();
    $lStorageArray['url'] = $pUrl;
    $lStorageArray['score'] = $pScore;
    $lStorageArray['verb'] = $pVerb;
    $lStorageArray['title'] = $pTitle;
    $lStorageArray['description'] = $pDescription;
    $lStorageArray['photo'] = $pPhoto;

    $lPersist = new PersistentVariable();
    $lPersist->setName('widgetauth_'.$pSessionId);
    $lPersist->setValue(serialize($lStorageArray));
    $lPersist->save();
    return false;
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
   * @param $pSocialObjectId
   * @param $pOnlineIdentity
   * @param $pType
   * @return unknown_type
   */
  public static function saveActivity($pSocialObject, $pUrl, $pUserId, $pOnlineIdentitys, $pServicesId, $pScore, $pVerb) {
    $lActivity = new YiidActivity();
    $lActivity->setUId($pUserId);
    $lActivity->setSoId($pSocialObject->getId());
    $lActivity->setUrl($pUrl);
    $lActivity->setUrlHash(md5($pUrl));
    $lActivity->setOiids($pOnlineIdentitys);
    $lActivity->setCids($pServicesId);
    $lActivity->setScore($pScore);
    $lActivity->setVerb($pVerb);
    $lActivity->setC(time());
    $lActivity->save();
  }



  /**
   *
   * @author Christian Weyand
   * @param $pSocialObjectId
   * @param $pOnlineIdentitys
   * @return unknown_type
   */
  public static function isActionOnObjectAllowed($pSocialObjectId, $pUserId) {
    $lAlreadyPerformedActivity = self::retrieveActionOnObjectById($pSocialObjectId, $pUserId);
    return $lAlreadyPerformedActivity?false:true;
  }

  /**
   *
   * @author Christian Weyand
   * @param $pSocialObjectId
   * @param $pOnlineIdentitys
   * @return unknown_type
   */
  public static function retrieveActionOnObjectById($pSocialObjectId, $pUserId) {
    $lCollection = self::getMongoCollection();
    return self::initializeObjectFromCollection($lCollection->findOne(array("so_id" => $pSocialObjectId, "u_id" => $pUserId ) ));
  }


  public static function retrieveLatestActivitiesByContacts($pUserId, $pFriendId = null, $pCommunityId = null, $pLimit = 10, $pOffset = 1) {
    $lCollection = self::getMongoCollection();

    $lRelevantOis = self::getRelevantOnlineIdentitysForQuery($pUserId, $pFriendId);

    $lQueryArray = array();
    $lQueryArray['oiids'] = array('$in' => $lRelevantOis);
    if ($pCommunityId) {
      $lQueryArray['cids'] = array('$in' => array($pCommunityId));
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
   * @param $pId
   * @param integer $pLimit
   * @param integer $pPage
   * @return unknown_type
   */
  public static function retrieveByYiidActivityId($pUserId, $pId, $pCase, $pLimit = 10, $pOffset = 1){
    $lCollection = self::getMongoCollection();
    $lRelevantOis = self::getRelevantOnlineIdentitysForQuery($pUserId, null);

    $lQueryArray = array();
    // filters friends
    //$lQueryArray['oiids'] = array('$in' => $lRelevantOis);
    $lQueryArray['so_id'] = new MongoId($pId);
    $lQueryArray = array_merge($lQueryArray, self::addCaseQuery($pCase));

    $lResults = $lCollection->find($lQueryArray);
    $lResults->sort(array('u' => -1));

    $lResults->limit($pLimit)->skip(($pOffset - 1) * $pLimit);

    return self::hydrateMongoCollectionToObjects($lResults);
  }



  /**
   * transforms $pCase from action into score values for MongoDB
   * @param string $pCase
   * @author weyandch
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
   * returns a list of OI's we need for the query
   * @param unknown_type $pUserId
   * @param unknown_type $pFriendId
   */
  public static function getRelevantOnlineIdentitysForQuery($pUserId, $pFriendId) {
    return UserRelationTable::getRelevantOnlineIdentitys($pUserId, $pFriendId);
  }






  /**
   * check if the given verb is supported in the current version
   *
   * @param $pVerb
   * @return boolean
   */
  public static function isVerbSupported($pVerb) {
    return in_array($pVerb, sfConfig::get('app_likewidget_types'));
  }

  /**
   * @author weyandch
   * @param $pUrl
   * @return unknown_type
   */
  public static function retrieveSocialObjectByUrl($pUrl) {
    return SocialObjectTable::retrieveByUrl($pUrl);
  }

  /**
   * retrieves an social object for a given url
   *
   * @author Christian Weyand
   * @param string $pUrl
   * @return SocialObject
   */
  public static function retrieveSocialObjectByAliasUrl($pUrl) {
    return SocialObjectTable::retrieveByAliasUrl($pUrl);
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
   * @return array(SocialObject)
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

}
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


    if (!YiidActivityPeer::isVerbSupported($pVerb)) {
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
          $lSocialObject =  SocialObjectPeer::createSocialObject($pUrl, $pLongUrl, $pTitle, $pDescription, $pPhoto);
        }
      } else {
        $lSocialObject = SocialObjectPeer::createSocialObject($pUrl, null, $pTitle, $pDescription, $pPhoto);
      }
    } else {
      // unless we got an freaky object parser we check on updates on every action on an object
      $lSocialObject->updateObjectMasterData($pTitle, $pDescription, $pPhoto);

    }

    if (!self::isActionOnObjectAllowed($lSocialObject->getId(), $pUserId)) {
      return false;
    }

    foreach ($pGivenOnlineIdentitys as $lIdentity) {
      if (in_array($lIdentity, $pOwnedOnlineIdentitys)) {
        $lVerifiedOnlineIdentitys[]= $lIdentity;
        $senderOi = OnlineIdentityPeer::retrieveByPK($lIdentity);
        $lStatus = $senderOi->sendStatusMessage($pUrl, $pVerb, $pScore, utf8_decode($pTitle));
        sfContext::getInstance()->getLogger()->debug("{YiidActivityPeer}{saveLikeActivitys} Status Message: " . print_r($lStatus, true));
      }
      else {
      }
    }

    if (!empty($lVerifiedOnlineIdentitys)) {
      self::saveActivity($lSocialObject, $pUrl, $pUserId, $pScore, $pVerb);
      $lSocialObject->updateObjectOnLikeActivity($lVerifiedOnlineIdentitys, $pUrl, $pScore);
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
  public static function saveActivity($pSocialObject, $pUrl, $pUserId, $pScore, $pVerb) {
    $lActivity = new YiidActivity();
    $lActivity->setUId($pUserId);
    $lActivity->setSoId($pSocialObject->getId());
    $lActivity->setUrl($pUrl);
    $lActivity->setUrlHash(md5($pUrl));
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
    $lSocialObject = SocialObjectTable::retrieveByUrl($pUrl);
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
      $lObject->fromArray($pCollection, BasePeer::TYPE_FIELDNAME);
      return $lObject;
    }
    return null;
  }

}
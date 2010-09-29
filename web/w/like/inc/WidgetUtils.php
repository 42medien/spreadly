<?php
require_once('../../../lib/utils/UrlUtils.php');
require_once('../../../lib/vendor/sqs.php');
require_once('../../../lib/utils/YiidStatsSingleton.php');

/**
 *
 *
 * @author Christian Weyand
 */
class MongoSessionPeer {

  const MONGO_COLLECTION = 'session';

  /**
   * extracts the userid from the current session
   *
   * @author Christian Weyand
   * @param $pSessionId
   * @return int|boolean
   */
  public static function extractUserIdFromSession($pSessionId) {
    $lSession = self::getSessionData($_COOKIE[$pSessionId]);

    $lEncodedData = $lSession['sess_data'];
    session_decode($lEncodedData);
    $pUserId = $_SESSION['symfony/user/sfUser/attributes']['user_session']['id'];
    return $pUserId?$pUserId:false;
  }

  /**
   * returns the complete session-data
   *
   * @author Christian Weyand
   * @param $pId
   * @return unknown_type
   */
  public static function getSessionData($pId) {
    $lMongo = new Mongo(LikeSettings::MONGO_HOSTNAME);
    $pCollectionObject = $lMongo->selectCollection(LikeSettings::MONGO_DATABASENAME, self::MONGO_COLLECTION);

    return $pCollectionObject->findOne(array("sess_id" => $pId) );
  }
}

/**
 * Wrapper for accessing MongoObject without Sf Context (raw button)
 *
 * @author Christian Weyand
 */
class SocialObjectPeer {

  const MONGO_COLLECTION = 'social_object';

  /**
   * returns socialobject for a given url
   *
   * @param string $pUrl
   * @param int $pIsUsed
   * @return array()
   */
  public static function getDataForUrl($pUrl, $pIsUsed = false) {
    $pUrl = urldecode($pUrl);
    $pUrl = str_replace(" ", "+", $pUrl);

    $lMongo = new Mongo(LikeSettings::MONGO_HOSTNAME);
    $pCollectionObject = $lMongo->selectCollection(LikeSettings::MONGO_DATABASENAME, self::MONGO_COLLECTION);
    $pUrlHash = md5($pUrl);

    // check if we know the URL already
    $lSocialObjectArray = $pCollectionObject->findOne(array("alias" => array('$in' => array($pUrlHash)) ));

    // if no data is available, initialize empty array & create social object
    if (!$lSocialObjectArray) {
      self::delegateSocialObjectParsing($pUrl);
      $lSocialObjectArray = array();
    }

    if($pUrl && !UrlUtils::isUrlValid($pUrl)) {
	    $lSocialObjectArray = array_merge(array(
	      'urlerror'   => true,
	    ), $lSocialObjectArray);
    }

    // set counts for like on 0 if they're not set yet
    $lSocialObjectArray = array_merge(array(
      'l_cnt'   => 0,
      'd_cnt' => 0,
    ), $lSocialObjectArray);

    return $lSocialObjectArray;
  }

  /**
   * If an user did vote on an social object withdraw his score from displayed result
   *
   * @param array() $pSocialObjectArray
   * @param boolean $pUserAction
   * @return array()
   */
  public static function recalculateCountsRespectingUser($pSocialObjectArray, $pUserAction = false) {

    if ($pUserAction !== false) {
      switch ($pUserAction) {
        case 1: $pSocialObjectArray['l_cnt'] = $pSocialObjectArray['l_cnt']-1;
        break;
        case -1: $pSocialObjectArray['d_cnt'] = $pSocialObjectArray['d_cnt']-1;
        break;
      }
    }
    return $pSocialObjectArray;
  }


  /**
   * prototype function to send msgs in a queue
   * push a note to amazon sqs.. alpha stage!
   *
   * @author Christian Weyand
   */
  public static function delegateSocialObjectParsing($pUrl) {
    if ($pUrl) {
      $queue = 'SocialObjectParser'.'-'.LikeSettings::ENVIRONMENT;

      $service = new SQS('AKIAJ5NSA6ET5RC4AMXQ','bs1YgS4c1zJN/HmwaVA8CkhNfyvcS+EEm1hcEOa0');
      $service->createQueue($queue);

      $pUrl = urlencode($pUrl);
      $service->sendMessage($queue, $pUrl);
    }
  }
}

/**
 * Wrapper to access activity items within th ebutton
 */
class YiidActivityObjectPeer {
  const MONGO_COLLECTION = 'yiid_activity';

  /**
   * @todo phpdoc
   * @author Christian Weyand
   * @param $string pUrl
   * @param int $pUserId
   * @return false or score of action taken (-1/1)
   */
  public static function actionOnObjectByUser($pSocialObjectId, $pUserId) {
    $lMongo = new Mongo(LikeSettings::MONGO_HOSTNAME);
    $pCollectionObject = $lMongo->selectCollection(LikeSettings::MONGO_DATABASENAME, self::MONGO_COLLECTION);
    $lObject = $pCollectionObject->findOne(array("so_id" => $pSocialObjectId, "u_id" => intval($pUserId) ));
    return $lObject?$lObject['score']:false;
  }



}

/**
 * @todo phpdoc
 *
 */
class UserRelationPeer {
  const MONGO_COLLECTION = 'user_relation';

  /**
   * @todo phpdoc
   * @author Christian Weyand
   * @param $string pUrl
   * @param int $pUserId
   * @return false or score of action taken (-1/1)
   */
  public static function getFriendsOfUser($pUserId, $pLimit = 8) {
    $lMongo = new Mongo(LikeSettings::MONGO_HOSTNAME);
    $pCollectionObject = $lMongo->selectCollection(LikeSettings::MONGO_DATABASENAME, self::MONGO_COLLECTION);
    $lResults = $pCollectionObject->find(array("user_id" => $pUserId));
    $lResults->limit($pLimit);

    return $lResults;
  }
}
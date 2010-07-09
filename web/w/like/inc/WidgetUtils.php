<?php
require_once('../../../lib/utils/UrlUtils.php');
require_once('../../../lib/vendor/sqs.php');

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
 * @todo phpdoc
 *
 * @author Christian Weyand
 */
class SocialObjectPeer {

  const MONGO_COLLECTION = 'social_object';

  /**
   * @todo phpdoc
   *
   * @param unknown_type $pUrl
   * @param unknown_type $pIsUsed
   * @return unknown
   */
  public static function getDataForUrl($pUrl, $pIsUsed = false) {
    $pUrl = urldecode($pUrl);
    $lMongo = new Mongo(LikeSettings::MONGO_HOSTNAME);
    $pCollectionObject = $lMongo->selectCollection(LikeSettings::MONGO_DATABASENAME, self::MONGO_COLLECTION);
    $pUrlHash = md5($pUrl);

    $lSocialObjectArray = $pCollectionObject->findOne(array("alias" => array('$in' => array($pUrlHash)) ));
    //var_dump($lSocialObejctArray);die();

    // if no data is available, initialize empty array
    if (!$lSocialObjectArray) {
    //  self::delegateSocialObjectParsing($pUrl);
      $lSocialObjectArray = array();
    }

    // set counts for like on 0 if not set
    $lSocialObjectArray = array_merge(array(
      'l_cnt'   => 0,
      'd_cnt' => 0,
    ), $lSocialObjectArray);
    /*
     if ($pIsUsed !== false) {
     switch ($pIsUsed) {
     case 1: $lSocialObjectArray['l_cnt'] = $lSocialObjectArray['l_cnt']-1;
     break;
     case -1: $lSocialObjectArray['d_cnt'] = $lSocialObjectArray['d_cnt']-1;
     break;
     }
     }*/
    return $lSocialObjectArray;
  }

  /**
   * @todo phpdoc
   *
   * @param unknown_type $pSocialObjectArray
   * @param unknown_type $pUserAction
   * @return unknown
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
   *
   * @todo phpdoc
   * @author Christian Weyand
   */
  public static function delegateSocialObjectParsing($pUrl) {
    if ($pUrl) {
      $queue = 'testerle1';

      $service = new SQS('AKIAJ5NSA6ET5RC4AMXQ','bs1YgS4c1zJN/HmwaVA8CkhNfyvcS+EEm1hcEOa0');
      $service->createQueue($queue);

      $pUrl = urlencode($pUrl);
      $service->sendMessage($queue, $pUrl);
    }
  }
}

/**
 * @todo phpdoc
 *
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

    $lObject = $pCollectionObject->findOne(array("so_id" => (string)$pSocialObjectId, "u_id" => $pUserId ));
    return $lObject?$lObject['score']:false;
  }
}
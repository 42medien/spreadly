<?php
require_once('../../../lib/utils/UrlUtils.php');
require_once('../../../lib/utils/aws/sqs.php');

/**
 * Enter description here...
 *
 * @author Matthias Pfefferle
 */
class WidgetUtils {
  private $aMongoConn = null;

  private $aUrl = null;
  private $aTitle = null;
  private $aDescription = null;
  private $aPhoto = null;
  private $aTags = null;
  private $aUserId = null;
  private $aSocialObject = null;
  private $aDeal = null;

  public function __construct($pUrl, $pTitle = null, $pDescription = null, $pPhoto = null, $pTags = null) {
    $this->aMongoConn = new Mongo(LikeSettings::MONGO_HOSTNAME);

    $this->aUrl = urldecode($pUrl);
    $this->aTitle = $pTitle;
    $this->aDescription = $pDescription;
    $this->aPhoto = $pPhoto;
    $this->aTags = $pTags;
    $this->aUserId = $this->extractUserIdFromSession();
    $this->aSocialObject = $this->getSocialObjectByUrl();
    $this->aDeal = $this->getActiveDeal();
  }

  public function getUserId() {
    return $this->aUserId;
  }

  public function getSocialObject() {
    return $this->aSocialObject;
  }

  public function getDeal() {
    return $this->aDeal;
  }

  /**
   * extracts the userid from the current session
   *
   * @author Christian Weyand
   * @param $pSessionId
   * @return int|boolean
   */
  public function extractUserIdFromSession() {
    if (!array_key_exists(LikeSettings::SF_SESSION_COOKIE, $_COOKIE)) {
      return false;
    }

    $pCollectionObject = $this->aMongoConn->selectCollection(LikeSettings::MONGO_DATABASENAME, "session");
    $lSession = $pCollectionObject->findOne(array("sess_id" => $_COOKIE[LikeSettings::SF_SESSION_COOKIE]) );

    $lEncodedData = $lSession['sess_data'];
    session_decode($lEncodedData);
    $pUserId = $_SESSION['symfony/user/sfUser/attributes']['user_session']['id'];

    return $pUserId?$pUserId:false;
  }

  /**
   * returns socialobject for a given url
   *
   * @return array()
   */
  public function getSocialObjectByUrl() {
    $pUrl = str_replace(" ", "+", $this->aUrl);

    $pCollectionObject = $this->aMongoConn->selectCollection(LikeSettings::MONGO_DATABASENAME, 'social_object');
    $pUrlHash = md5(UrlUtils::skipTrailingSlash($pUrl));

    // check if we know the URL already
    $lSocialObjectArray = $pCollectionObject->findOne(array("alias" => array('$in' => array($pUrlHash)) ));

    // if no data is available, initialize empty array & create social object
    if (!$lSocialObjectArray) {
      // don't do that.. too much objects in the queue atm
      $lSocialObjectArray = array();
    }

    if($pUrl && !UrlUtils::isUrlValid($pUrl)) {
      $lSocialObjectArray = array_merge(array(
        'urlerror'   => true,
      ), $lSocialObjectArray);
    }

    // set counts for like on 0 if they're not set yet
    $lSocialObjectArray = array_merge(array(
      'l_cnt' => 0,
      'd_cnt' => 0,
    ), $lSocialObjectArray);

    return $lSocialObjectArray;
  }

  /**
   * check if a given user already performed an action on a social object
   * returns false if not, or it's score (1/-1)
   *
   * @author Christian Weyand
   * @param int $pSocialObjectId
   * @param int $pUserId
   * @return false or score of action taken (-1/1)
   */
  public function getYiidActivity() {
    $lSocialObject = $this->getSocialObject();

    if (!array_key_exists('_id', $lSocialObject)) {
      return null;
    }

    $lUserId = $this->aUserId;
    $lActiveDeal = $this->aDeal;

    $pCollectionObject = $this->aMongoConn->selectCollection(LikeSettings::MONGO_DATABASENAME, 'yiid_activity');

    // get yiid-activity and factor a deal
    if ($lActiveDeal) {
      $lObject = $pCollectionObject->findOne(array("so_id" => $lSocialObject['_id'],
                                                   "u_id" => intval($lUserId),
                                                   "d_id" => intval($lActiveDeal['id'])
                                                  ));

    } else {
      $lObject = $pCollectionObject->findOne(array("so_id" => $lSocialObject['_id'],
                                                   "u_id" => intval($lUserId),
                                                   "d_id" => array('$exists' => false)
                                                  ));
    }

    return $lObject;
  }

  /**
   * check if a given user already performed an action on a social object
   * returns false if not, or it's score (1/-1)
   *
   * @author Christian Weyand
   * @param int $pSocialObjectId
   * @param int $pUserId
   * @return false or score of action taken (-1/1)
   */
  public function actionOnHostByUser($pUserId, $pActiveDeal) {

    $pCollectionObject = $this->aMongoConn->selectCollection(LikeSettings::MONGO_DATABASENAME, 'yiid_activity');

    // get yiid-activity and factor a deal
    $lObject = $pCollectionObject->findOne(array("u_id" => intval($pUserId),
                                                 "d_id" => intval($pActiveDeal['id'])
                                                  ));
    return $lObject;
  }

  /**
   * extracts yiidit Parameter if it's given, returns null if its not set or referal == buttonUro
   *
   * @param string $pButtonUri
   * @param string $pReferrerUri
   * @return string|null
   */
  public function extractClickback() {
    $pUrl = $this->aUrl;
    $pReferrerUri = @$_SERVER['HTTP_REFERER'];

    if (!$pReferrerUri) {
      return null;
    }
    if ($pButtonUri == $pReferrerUri) {
      return null;
    }

    $lParameterList = parse_url($pReferrerUri);

    $lGetParams = array();
    parse_str($lParameterList['query'], $lGetParams);

    return (isset($lGetParams['yiidit']))?$lGetParams['yiidit']:null;
  }

  /**
   * searches the mongo for an active deal
   *
   * @author Matthias Pfefferle
   * @param string $pUrl
   * @param string $pTags comma separated
   * @return array|boolean
   */
  public function getActiveDeal() {
    $pTags = $this->aTags;
    $pUrl = str_replace(" ", "+", $this->aUrl);
    $pUrl = UrlUtils::skipTrailingSlash($pUrl);

    $host = parse_url($pUrl, PHP_URL_HOST);
    $col = $this->aMongoConn->selectCollection(LikeSettings::MONGO_DATABASENAME, 'deals');

    $today = new MongoDate(time());
    $cond = array(
      "host" => $host,
      "start_date" => array('$lte' => $today),
      "end_date" => array('$gte' => $today)
    );

    // added tags to the conditions
    if ($pTags) {
      // trim tags
      $pTags = explode(",", $pTags);
      $lTags = array();
      foreach ($pTags as $lTag) {
        $lTags[] = trim($lTag);
      }
      $cond['$or'] = array(array('tags' => array('$exists' => false)), array('tags' => array('$in' => $lTags)));
    } else {
      $cond["tags"] = array('$exists' => false);
    }

    $result = $col->find($cond)->limit(1)->sort(array("start_date" => -1));
    $deal = null;

    if($result->hasNext()) {
      $deal = $result->getNext();
    }

    if ($deal && ($deal["is_unlimited"] == true || $deal['remaining_coupon_quantity'] > 0)) {
      if (!$deal || $this->actionOnHostByUser($this->aUserId, $deal)) {
        return null;
      }
      return $deal;
    }

    return null;
  }

  /**
   * encapsulates all trackings
   */
  public function trackUser() {
    $this->trackPageImpression($this->aUrl, $this->extractClickback(), $this->aUserId);
    $this->trackVisit($this->aUrl);
  }

  /**
   * tracks a visit on given url
   *
   * @param string $pUrl
   * @author weyandch
   */
  public function trackVisit($pUrl) {
    $lCollection = $this->aMongoConn->selectCollection(LikeSettings::MONGO_STATS_DATABASENAME, 'visit');

    $pUrl = urldecode($pUrl);

    // data is stored as a tupel of host && month (host => example.com, month => 2010-10)
    $lQueryArray = array();
    $lQueryArray['host'] = parse_url($pUrl, PHP_URL_HOST);
    $lQueryArray['month'] = date('Y-m');

    if ($lQueryArray['host'] != '') {
      $lUpdateArray = array( '$inc' => array('stats.day_'.date('d').'.pis' => 1, 'pis_total' => 1));
      $lCollection->update($lQueryArray, $lUpdateArray, array('upsert' => true));
    }
  }

  /**
   * Enter description here...
   *
   * @param string $pUrl
   * @param string $pClickback
   * @param int $pUser
   */
  public function trackPageImpression($pUrl, $pClickback, $pUser) {
    $lHost = parse_url($pUrl, PHP_URL_HOST);
    $lCollection = $this->aMongoConn->selectCollection(LikeSettings::MONGO_STATS_DATABASENAME, str_replace('.', '_', $lHost).".analytics.pis");

    if (mb_detect_encoding($pUrl) != 'UTF-8') {
      $pUrl = utf8_encode($pUrl);
    }

    $lDoc = array(
      'url' => $pUrl,
      'date' => new MongoDate(strtotime(date("Y-m-d")))
    );

    $lOptions = array("total" => 1);

    if ($pUser) {
      $lOptions["yiid"] = 1;
    }

    if ($pClickback) {
      $lOptions["cb"] = 1;
    }

    $lCollection->update($lDoc, array('$inc' => $lOptions), array("upsert" => true));
  }

  /**
   * destructor to close mongo-connection
   */
  public function __destruct() {
    $this->aMongoConn->close();
  }
}
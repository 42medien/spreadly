<?php
/**
 * the buttons swiss-knife
 *
 * @author Matthias Pfefferle
 * @author Hannes Schippmann
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
  private $aYiidActivity = null;
  private $aShowFriends = false;

  public function __construct() {
    try {
      $this->aMongoConn = new Mongo(LikeSettings::MONGO_HOSTNAME, array("timeout" => 5000));
    } catch (Exception $e) {
      // do nothing
    }

    if (isset($_GET['url']) && !empty($_GET['url'])) {
      $this->aUrl = urldecode($_GET['url']);
    } else {
      $this->aUrl = urldecode($_SERVER['HTTP_REFERER']);
    }

    if (isset($_GET['social']) && !empty($_GET['social'])) {
      $this->aShowFriends = true;
    }

    $this->aTitle = urldecode(@$_GET['title']);
    $this->aDescription = urldecode(@$_GET['description']);
    $this->aPhoto = urldecode(@$_GET['photo']);
    $this->aTags = trim(urldecode(@$_GET['tags']));
    $this->aUserId = $this->extractUserIdFromSession();
    $this->aSocialObject = $this->getSocialObjectByUrl();
    $this->aDeal = $this->getActiveDeal();
    $this->aYiidActivity = $this->getYiidActivityBySocialObject();
  }

  public function getPopupUrl() {
    return LikeSettings::JS_POPUP_PATH."?ei_kcuf=".time()."&title=".urlencode($this->aTitle)."&description=".urlencode($this->aDescription)."&photo=".urlencode($this->aPhoto)."&tags=".urlencode($this->aTags)."&url=".urlencode($this->aUrl)."&clickback=".urlencode($this->extractClickback());
  }

  public function showFriends() {
    if (!$this->aMongoConn) {
      return false;
    }

    return $this->getUserId() && $this->aShowFriends && $this->aSocialObject;
  }

  public function getUserId() {
    return $this->aUserId;
  }

  public function getSocialObject() {
    return $this->aSocialObject;
  }

  public function getYiidActivity() {
    return $this->aYiidActivity;
  }

  public function getSocialObjectId() {
    return strval($this->aSocialObject['_id']);
  }

  public function getDeal() {
    return $this->aDeal;
  }

  public function getActivityCount() {
    if (!$this->aMongoConn) {
      return "?";
    }

    return intval($this->aSocialObject['l_cnt']);
  }

  public function getButtonClass() {
    if ($this->getYiidActivity()) {
      return "disabled";
    } elseif ($this->getDeal()) {
      return "deal";
    } else {
      return "";
    }
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

    // check if mongo is active
    if (!$this->aMongoConn) {
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
    // check if mongo is active
    if (!$this->aMongoConn) {
      return false;
    }

    $pCollectionObject = $this->aMongoConn->selectCollection(LikeSettings::MONGO_DATABASENAME, 'social_object');
    $pUrlHash = md5($this->skipTrailingSlash($this->aUrl));

    // check if we know the URL already
    $lSocialObjectArray = $pCollectionObject->findOne(array("alias" => array('$in' => array($pUrlHash)) ));

    // if no data is available, initialize empty array & create social object
    if (!$lSocialObjectArray) {
      // don't do that.. too much objects in the queue atm
      $lSocialObjectArray = array();
    }

    if ($pUrl && !$this->isUrlValid($pUrl)) {
      $lSocialObjectArray = array_merge(array(
        'urlerror'   => true,
      ), $lSocialObjectArray);
    }

    // set counts for like on 0 if they're not set yet
    $lSocialObjectArray = array_merge(array(
      'l_cnt' => 0
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
  public function getYiidActivityBySocialObject() {
    // check if mongo is active
    if (!$this->aMongoConn) {
      return false;
    }

    $lSocialObject = $this->getSocialObject();

    if (!array_key_exists('_id', $lSocialObject)) {
      return null;
    }

    $lUserId = $this->aUserId;
    $lActiveDeal = $this->aDeal;

    $pCollectionObject = $this->aMongoConn->selectCollection(LikeSettings::MONGO_DATABASENAME, 'yiid_activity');

    // get yiid-activity and factor a deal
    if ($lActiveDeal) {
      $lObject = $pCollectionObject->findOne(array('social_object.$id' => $lSocialObject['_id'],
                                                   'u_id' => intval($lUserId),
                                                   'd_id' => intval($lActiveDeal['id'])
                                                  ));

    } else {
      $lObject = $pCollectionObject->findOne(array('social_object.$id' => $lSocialObject['_id'],
                                                   'u_id' => intval($lUserId),
                                                   'd_id' => array('$exists' => false)
                                                  ));
    }

    return $lObject;
  }

  private function findYiidActivityById($pId) {
    $pCollectionObject = $this->aMongoConn->selectCollection(LikeSettings::MONGO_DATABASENAME, 'yiid_activity');

    return $pCollectionObject->findOne(array("_id" => new MongoId($pId)));
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
    // check if mongo is active
    if (!$this->aMongoConn) {
      return false;
    }

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

    if (isset($lGetParams['spreadly'])) {
      return $lGetParams['spreadly'];
    } elseif (isset($lGetParams['yiidit'])) {
      return $lGetParams['yiidit'];
    } else {
      return null;
    }
  }

  /**
   * searches the mongo for an active deal
   *
   * @author Matthias Pfefferle
   * @param string $pUrl
   * @param string $pTags comma separated
   * @return array|boolean
   */
  private function getActiveDeal() {
    // check if mongo is active
    if (!$this->aMongoConn) {
      return false;
    }

    $pTags = $this->aTags;
    $pUrl = $this->skipTrailingSlash($this->aUrl);

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
    // check if mongo is active
    if (!$this->aMongoConn) {
      return false;
    }

    $this->trackClickback();
    $this->trackVisit();
  }

  /**
   * tracks a visit on given url
   *
   * @param string $pUrl
   * @author weyandch
   */
  private function trackVisit() {
    $lUrl = $this->aUrl;
    $lCollection = $this->aMongoConn->selectCollection(LikeSettings::MONGO_STATS_DATABASENAME, 'visit');

    $lUrl = urldecode($lUrl);

    // data is stored as a tupel of host && month (host => example.com, month => 2010-10)
    $lQueryArray = array();
    $lQueryArray['host'] = parse_url($lUrl, PHP_URL_HOST);
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
  private function trackClickback() {
    $lClickback = $this->extractClickback();
    $lClickback = explode('.', urldecode($lClickback));
    $lOriginYiidActivity = $this->findYiidActivityById($lClickback[1]);

    if($lOriginYiidActivity) {
      $url = str_replace(" ", "+", $this->aUrl);
      $host = parse_url($url, PHP_URL_HOST);
      $upsert = array('$inc' => array('cb' => 1, 's.'.$lClickback[0].'.cb' => 1));
      $options = array("upsert" => true);

      $this->aMongoConn->selectCollection(LikeSettings::MONGO_DATABASENAME, "yiid_activity")
           ->update($lOriginYiidActivity,
                    $upsert, $options);

      $this->aMongoConn->selectCollection(LikeSettings::MONGO_STATS_DATABASENAME, "analytics_activity")
           ->update(array('ya_id' => strval($lOriginYiidActivity['_id'])),
                    $upsert, $options);

      if(array_key_exists('d_id', $lOriginYiidActivity)) {
        $this->aMongoConn->selectCollection(LikeSettings::MONGO_STATS_DATABASENAME, "deal_stats.host")
             ->update(array('d_id' => $lOriginYiidActivity['d_id'],
                            'day' => new MongoDate(strtotime(date('Y-m-d', $lOriginYiidActivity['c'])))),
                      $upsert, $options);
        $this->aMongoConn->selectCollection(LikeSettings::MONGO_STATS_DATABASENAME, "deal_stats.url")
             ->update(array('d_id' => $lOriginYiidActivity['d_id'],
                            'url' => $url,
                            'day' => new MongoDate(strtotime(date('Y-m-d', $lOriginYiidActivity['c'])))),
                      $upsert, $options);
        $this->aMongoConn->selectCollection(LikeSettings::MONGO_STATS_DATABASENAME, "deal_summary.host")
             ->update(array('d_id' => $lOriginYiidActivity['d_id']),
                      $upsert, $options);
        $this->aMongoConn->selectCollection(LikeSettings::MONGO_STATS_DATABASENAME, "deal_summary.url")
             ->update(array('d_id' => $lOriginYiidActivity['d_id'],
                            'url' => $url),
                      $upsert, $options);
      } else {
        $this->aMongoConn->selectCollection(LikeSettings::MONGO_STATS_DATABASENAME, "activity_stats.host")
             ->update(array('host' => $host,
                            'day' => new MongoDate(strtotime(date('Y-m-d', $lOriginYiidActivity['c'])))),
                      $upsert, $options);
        $this->aMongoConn->selectCollection(LikeSettings::MONGO_STATS_DATABASENAME, "activity_stats.url")
             ->update(array('url' => $url,
                            'day' => new MongoDate(strtotime(date('Y-m-d', $lOriginYiidActivity['c'])))),
                      $upsert, $options);
        $this->aMongoConn->selectCollection(LikeSettings::MONGO_STATS_DATABASENAME, "summary.host")
             ->update(array('host' => $host),
                      $upsert, $options);
        $this->aMongoConn->selectCollection(LikeSettings::MONGO_STATS_DATABASENAME, "summary.url")
             ->update(array('url' => $url),
                      $upsert, $options);
      }
    }
  }

  /**
   * destructor to close mongo-connection
   */
  public function __destruct() {
    $this->aMongoConn->close();
  }

  /**
   * url validator
   *
   * @param string $pUrl
   * @return boolean
   */
  private function isUrlValid($pUrl) {
    $lPattern = '~^
        (https?|ftps?)://                       # http or ftp (+SSL)
        (
          ([a-z0-9-]+\.)+[a-z]{2,6}             # a domain name
            |                                   #  or
          \d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}    # a IP address
        )
        (:[0-9]+)?                              # a port (optional)
        (/?|\?\S+|/\S+)                         # a /, nothing or a / with something
      $~ix';

    return preg_match($lPattern, (string)$pUrl);
  }

  /**
   * transforms http://weyands.net/ to http://weyands.net
   *
   * @param string $pUrl
   * @return string
   */
  private function skipTrailingSlash($pUrl) {
    $pUrl = str_replace(" ", "+", $pUrl);
    if ('/' == substr($pUrl, strlen($pUrl)-1)) {
      $pUrl = substr_replace($pUrl, '', strlen($pUrl)-1);  // strip trailing slash
    }
    return $pUrl;
  }
}
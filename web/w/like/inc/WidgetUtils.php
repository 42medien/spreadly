<?php
/**
 * the buttons swiss-knife
 *
 * @author Matthias Pfefferle
 * @author Hannes Schippmann
 */
class WidgetUtils {
  private $aUrl = null;
  private $aTitle = null;
  private $aDescription = null;
  private $aPhoto = null;
  private $aTags = null;
  private $aUserId = null;
  private $aSocialObject = null;
  private $aYiidActivity = null;
  private $aShowFriends = false;
  private $aCounter = true;
  private $aHexColor = "1C2666";
  private $aColor = null;
  private $aLabel = "Like";
  private $aType = "default";

  public function __construct() {
    if (isset($_GET['url']) && !empty($_GET['url'])) {
      $this->aUrl = trim(urldecode($_GET['url']));
    } elseif(isset($_SERVER['HTTP_REFERER']) && !empty($_SERVER['HTTP_REFERER'])) {
      $this->aUrl = trim(urldecode($_SERVER['HTTP_REFERER']));
    } else {
      $this->aUrl = null;
    }

    // clean up the url
    $this->aUrl = self::cleanupHostAndUri($this->aUrl);

    if (isset($_GET['social']) && !empty($_GET['social'])) {
      $this->aShowFriends = true;
    }

    if (isset($_GET['type']) && !empty($_GET['type'])) {
      $this->aType = $_GET['type'];
    }

    if (isset($_GET['label']) && !empty($_GET['label'])) {
      $this->aLabel = $_GET['label'];
    }

    if (isset($_GET['counter'])) {
      $this->aCounter = (bool)urldecode(@$_GET['counter']);
    }

    if (isset($_GET['color']) && !empty($_GET['color'])) {
      $color = $this->aHexColor = $_GET['color'];
    } else {
      $color = $this->aHexColor = $this->aHexColor;
    }

    $this->aTitle = urldecode(@$_GET['title']);
    $this->aDescription = urldecode(@$_GET['description']);
    $this->aPhoto = urldecode(@$_GET['photo']);
    $this->aTags = trim(urldecode(@$_GET['tags']));
    $this->aUserId = $this->extractUserIdFromSession();
    $this->aSocialObject = $this->getSocialObjectByUrl();
    $this->aYiidActivity = $this->getYiidActivityBySocialObject();
    $this->aColor = $this->rgb2hsl($color);
  }

  public function getPopupUrl() {
    return LikeSettings::JS_POPUP_PATH."?ei_kcuf=".time()."&title=".urlencode($this->aTitle)."&description=".urlencode($this->aDescription)."&photo=".urlencode($this->aPhoto)."&tags=".urlencode($this->aTags)."&url=".urlencode($this->aUrl)."&clickback=".urlencode($this->extractClickback())."&color=".urlencode($this->aHexColor);
  }

  public function showFriends() {
    if (!$this->getMongoCon()) {
      return false;
    }

    return $this->aUrl && $this->getUserId() && $this->aShowFriends && $this->aSocialObject;
  }

  public function getUserId() {
    return $this->aUserId;
  }

  public function getType() {
    return $this->aType;
  }

  public function getSocialObject() {
    return $this->aSocialObject;
  }

  public function getLabel() {
    return $this->aLabel;
  }

  public function showCounter() {
    return $this->aCounter;
  }

  public function getHexColor() {
    return "#".$this->aHexColor;
  }

  public function getYiidActivity() {
    return $this->aYiidActivity;
  }

  public function getSocialObjectId() {
    if (array_key_exists("_id", $this->aSocialObject)) {
      return strval($this->aSocialObject['_id']);
    }

    return null;
  }

  public function getActivityCount() {
    if (!$this->getMongoCon()) {
      return "?";
    }

    return intval($this->aSocialObject['l_cnt']) + $this->getFacebookCount() + $this->getTwitterCount();
  }

  public function getButtonClass() {
    if ($this->getYiidActivity()) {
      return "disabled";
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
    $pUserId = false;

    if (!array_key_exists(LikeSettings::SF_SESSION_COOKIE, $_COOKIE)) {
      return false;
    }

    $lMongo = $this->getMongoCon();

    // check if mongo is active
    if (!$lMongo) {
      return false;
    }

    $pCollectionObject = $lMongo->selectCollection(LikeSettings::MONGO_DATABASENAME, "session");
    $lSession = $pCollectionObject->findOne(array("sess_id" => $_COOKIE[LikeSettings::SF_SESSION_COOKIE]) );

    if (!$lSession) {
      return false;
    }

    if (array_key_exists('sess_data', $lSession)) {
      $lEncodedData = $lSession['sess_data'];
      session_decode($lEncodedData);

      if (array_key_exists('symfony/user/sfUser/attributes', $_SESSION) &&
      array_key_exists('user_session', $_SESSION['symfony/user/sfUser/attributes']) &&
      array_key_exists('id', $_SESSION['symfony/user/sfUser/attributes']['user_session'])) {
        $pUserId = $_SESSION['symfony/user/sfUser/attributes']['user_session']['id'];
      }

      return $pUserId;
    } else {
      return false;
    }
  }

  /**
   * returns socialobject for a given url
   *
   * @return array()
   */
  public function getSocialObjectByUrl() {
    $lMongo = $this->getMongoCon();
    // check if mongo is active
    if (!$lMongo) {
      return false;
    }

    $pCollectionObject = $lMongo->selectCollection(LikeSettings::MONGO_DATABASENAME, 'social_object');
    $pUrlHash = md5($this->skipTrailingSlash($this->aUrl));

    // check if we know the URL already
    $lSocialObjectArray = $pCollectionObject->findOne(array("alias" => array('$in' => array($pUrlHash)) ));

    // if no data is available, initialize empty array & create social object
    if (!$lSocialObjectArray) {
      // don't do that.. too much objects in the queue atm
      $lSocialObjectArray = array();
    }

    if ($this->aUrl && !$this->isUrlValid($this->aUrl)) {
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
    $lMongo = $this->getMongoCon();
    // check if mongo is active
    if (!$lMongo) {
      return false;
    }

    $lSocialObject = $this->getSocialObject();

    if (!array_key_exists('_id', $lSocialObject)) {
      return null;
    }

    $lUserId = $this->aUserId;

    $pCollectionObject = $lMongo->selectCollection(LikeSettings::MONGO_DATABASENAME, 'yiid_activity');

    $lObject = $pCollectionObject->findOne(array('social_object.$id' => $lSocialObject['_id'],
                                                   'u_id' => intval($lUserId),
                                                   'd_id' => array('$exists' => false)
    ));

    return $lObject;
  }

  private function findYiidActivityById($pId) {
    $pCollectionObject = $this->getMongoCon()->selectCollection(LikeSettings::MONGO_DATABASENAME, 'yiid_activity');

    return $pCollectionObject->findOne(array("_id" => new MongoId($pId)));
  }

  /**
   * extracts yiidit Parameter if it's given, returns null if its not set or referal == buttonUro
   *
   * @param string $pButtonUri
   * @param string $pReferrerUri
   * @return string|null
   */
  public function extractClickback() {
    $pReferrerUri = @$_SERVER['HTTP_REFERER'];

    if (!$pReferrerUri) {
      return null;
    }

    $lParameterList = parse_url($pReferrerUri);

    $lGetParams = array();

    if (!array_key_exists("query", $lParameterList)) {
      return null;
    }
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
   * encapsulates all trackings
   */
  public function trackUser() {
    // check if mongo is active
    if (!$this->getMongoCon()) {
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
    $lCollection = $this->getMongoCon()->selectCollection(LikeSettings::MONGO_STATS_DATABASENAME, 'visit');

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

    // exit if there is no clickback
    if (!$lClickback) {
      return false;
      exit;
    }

    $lClickback = explode('.', urldecode($lClickback));
    $lOriginYiidActivity = $this->findYiidActivityById($lClickback[1]);

    if($lOriginYiidActivity) {
      $url = str_replace(" ", "+", $this->aUrl);
      $host = parse_url($url, PHP_URL_HOST);
      $upsert = array('$inc' => array('cb' => 1, 's.'.$lClickback[0].'.cb' => 1));
      $options = array("upsert" => true);

      $lMongo = $this->getMongoCon();

      $lMongo->selectCollection(LikeSettings::MONGO_DATABASENAME, "yiid_activity")
             ->update($lOriginYiidActivity, $upsert, $options);

      $lMongo->selectCollection(LikeSettings::MONGO_STATS_DATABASENAME, "analytics_activity")
             ->update(array('ya_id' => strval($lOriginYiidActivity['_id'])), $upsert, $options);

      $lMongo->selectCollection(LikeSettings::MONGO_STATS_DATABASENAME, "activity_stats.host")
             ->update(array('host' => $host,
                            'day' => new MongoDate(strtotime(date('Y-m-d', $lOriginYiidActivity['c'])))), $upsert, $options);
      $lMongo->selectCollection(LikeSettings::MONGO_STATS_DATABASENAME, "activity_stats.url")
             ->update(array('url' => $url,
                            'day' => new MongoDate(strtotime(date('Y-m-d', $lOriginYiidActivity['c'])))), $upsert, $options);
      $lMongo->selectCollection(LikeSettings::MONGO_STATS_DATABASENAME, "summary.host")
             ->update(array('host' => $host), $upsert, $options);
      $lMongo->selectCollection(LikeSettings::MONGO_STATS_DATABASENAME, "summary.url")
             ->update(array('url' => $url), $upsert, $options);
    }
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

  /**
   * removes unwanted GET-Parameters and strips #anchors
   *
   * @author Christian Weyand
   * @param $pUrl
   * @return unknown_type
   */
  public static function cleanupHostAndUri($pUrl) {
    if (!$pUrl) {
      return null;
    }

    $pUrl = urldecode($pUrl);
    $pUrl = str_replace(" ", "+", $pUrl);

    // @see add this
    if ($url_fragment = parse_url($pUrl, PHP_URL_FRAGMENT)) {
      $pUrl = str_replace("#".$url_fragment, "", $pUrl);
    }

    $parameterList = parse_url($pUrl);

    if (!array_key_exists("scheme", $parameterList)) {
      return false;
    }

    $pQueryString = '';
    $lKeysToRemove = LikeSettings::$TRACKING_PARAMS;
    if (isset($parameterList['path'])) {
      $pQueryString .= $parameterList['path'];
    }
    if (array_key_exists("query", $parameterList)) {
      $lGetParams = array();
      parse_str($parameterList['query'], $lGetParams);
      $parameterList['params'] = array_diff_key($lGetParams, array_fill_keys($lKeysToRemove, 0));
      $pQueryString .= (!empty($parameterList['params']))?'?'.http_build_query($parameterList['params']):'';
    }
    return $parameterList['scheme'].'://'.$parameterList['host'].$pQueryString;
  }

  /**
   * returns a mongo instance
   *
   * @return Mongo|null
   */
  private function getMongoCon() {
    // checks if mongo is running
    try {
      $mongo = new Mongo(LikeSettings::MONGO_HOSTNAME, array("timeout" => 5000));
      return $mongo;
    } catch (Exception $e) {
      error_log($e->getMessage());
      return null;
    }
  }

  public function getTwitterCount() {
    $ch = curl_init();
    curl_setopt_array($ch, array(
      CURLOPT_URL => 'http://urls.api.twitter.com/1/urls/count.json?url=' . $this->aUrl,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_TIMEOUT => 1,
      CURLOPT_CONNECTTIMEOUT => 1,
    ));
    $rawData = curl_exec($ch);
    curl_close($ch);

    if($twitterData = json_decode($rawData, true)) {
      return intval($twitterData['count']);
    }

    return intval(0);
  }

  public function getFacebookCount() {
    $ch = curl_init();
    curl_setopt_array($ch, array(
      CURLOPT_URL => 'http://graph.facebook.com/?ids=' . $this->aUrl,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_TIMEOUT => 1,
      CURLOPT_CONNECTTIMEOUT => 1,
    ));
    $rawData = curl_exec($ch);
    curl_close($ch);

    if($facebookData = json_decode($rawData, true)) {
      if (array_key_exists($this->aUrl, $facebookData) && array_key_exists('shares', $facebookData[$this->aUrl])) {
        return intval($facebookData[$this->aUrl]['shares']);
      }
    }

    return intval(0);
  }

  public function getH() {
    return round($this->aColor[0] * 360);
  }

  public function getS() {
    return $this->aColor[1] * 100;
  }

  public function getL() {
    return $this->aColor[2] * 100;
  }

  public function rgb2hsl($rgb){
    $rgb = str_replace("#", "", $rgb);

    $redhex  = substr($rgb,0,2);
    $greenhex = substr($rgb,2,2);
    $bluehex = substr($rgb,4,2);

    $var_r = (hexdec($redhex)) / 255;
    $var_g = (hexdec($greenhex)) / 255;
    $var_b = (hexdec($bluehex)) / 255;
    $var_min = min($var_r,$var_g,$var_b);
    $var_max = max($var_r,$var_g,$var_b);
    $del_max = $var_max - $var_min;

    $l = ($var_max + $var_min) / 2;

    if ($del_max == 0) {
      $h = 0;
      $s = 0;
    } else {
      if ($l < 0.5) {
        $s = $del_max / ($var_max + $var_min);
      } else {
        $s = $del_max / (2 - $var_max - $var_min);
      };

      $del_r = ((($var_max - $var_r) / 6) + ($del_max / 2)) / $del_max;
      $del_g = ((($var_max - $var_g) / 6) + ($del_max / 2)) / $del_max;
      $del_b = ((($var_max - $var_b) / 6) + ($del_max / 2)) / $del_max;

      if ($var_r == $var_max) {
        $h = $del_b - $del_g;
      } elseif ($var_g == $var_max) {
        $h = (1 / 3) + $del_r - $del_b;
      } elseif ($var_b == $var_max) {
        $h = (2 / 3) + $del_g - $del_r;
      };

      if ($h < 0) {
        $h += 1;
      };

      if ($h > 1) {
        $h -= 1;
      };
    };

    return array($h, $s, $l);
  }

  public function alter_brightness($colourstr, $steps) {
    $colourstr = str_replace('#','',$colourstr);

    $rhex = substr($colourstr,0,2);
    $ghex = substr($colourstr,2,2);
    $bhex = substr($colourstr,4,2);

    $r = hexdec($rhex);
    $g = hexdec($ghex);
    $b = hexdec($bhex);

    $r = dechex(max(0,min(255,$r + $steps)));
    $g = dechex(max(0,min(255,$g + $steps)));
    $b = dechex(max(0,min(255,$b + $steps)));

    $r = str_pad($r,2,"0");
    $g = str_pad($g,2,"0");
    $b = str_pad($b,2,"0");

    $cor = '#'.$r.$g.$b;

    return $cor;
  }
}
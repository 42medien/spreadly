<?php
/**
 * Api to post twitter status messages
 *
 * @author Matthias Pfefferle
 */
class LinkedinPostApiClient extends PostApi {

  /**
   * defines the post function
   *
   * @param OnlineIdentity $pOnlineIdentity
   * @param string $pUrl if the url is not part of the message
   * @param string $pType
   * @param string $pScore
   * @param string $pMessage
   * @return int status code
   */
  public function doPost(OnlineIdentity $pOnlineIdentity, $pUrl, $pType, $pScore, $pTitle = null, $pDescription = null, $pPhoto = null) {
    $lToken = AuthTokenTable::getByUserAndOnlineIdentity($pOnlineIdentity->getUserId(), $pOnlineIdentity->getId());
    if (!$lToken) {
      $pOnlineIdentity->setSocialPublishingEnabled(false);
      $pOnlineIdentity->save();
      return false;
    }

    $lStatusMessage = $this->generateShareMessage($pType, $pScore, $pUrl, $pTitle, $pDescription, $pPhoto);

    $lPostBody = $lStatusMessage;
    $lConsumer = new OAuthConsumer(sfConfig::get("app_linkedin_oauth_token"), sfConfig::get("app_linkedin_oauth_secret"));
    $lStatus = OAuthClient::post($lConsumer, $lToken->getTokenKey(), $lToken->getTokenSecret(), "http://api.linkedin.com/v1/people/~/shares", $lPostBody, null, array("Content-Type: application/xml"), "http://api.linkedin.com");

    return $lStatus;
  }

  /**
   * generate Wildcard.. truncate if necessary, $pUrl is optional
   *
   * @param string $pType
   * @param int $pScore
   * @param string $pTitle
   * @param string $pUrl
   * @return string
   */
  public static function generatePostMessage($pType, $pScore, $pUrl, $pTitle = null, $pDescription = null, $pPhoto = null) {
    sfProjectConfiguration::getActive()->loadHelpers(array('Text', 'Url', 'Tag'));

    $lHashtag = self::$aHashtags[$pType][$pScore];

    if ($pTitle) {
      $lTitle = $pTitle;
    } else {
      $lTitle = parse_url ($pUrl, PHP_URL_HOST);
    }

    $lLink = link_to($lTitle, $pUrl);

    $lStatusMessage = '<activity locale="en_US"><content-type>linkedin-html</content-type><body>';
    $lStatusMessage .= htmlentities($lLink) . " " . $lHashtag;
    $lStatusMessage .= '</body></activity>';

    return $lStatusMessage;
  }

  /**
   * generate Wildcard.. truncate if necessary, $pUrl is optional
   *
   * @param string $pType
   * @param int $pScore
   * @param string $pTitle
   * @param string $pUrl
   * @return string
   */
  public static function generateShareMessage($pType, $pScore, $pUrl, $pTitle = null, $pDescription = null, $pPhoto = null) {
    sfProjectConfiguration::getActive()->loadHelpers(array('Text', 'Url', 'Tag'));

    $lHashtag = self::$aHashtags[$pType][$pScore];

    $lStatusMessage = '<?xml version="1.0" encoding="UTF-8"?><share>';
    $lStatusMessage .= "<comment>".self::$aHashtags[$pType][$pScore]."</comment>";
    $lStatusMessage .= '<content>';
    $lStatusMessage .= "<submitted-url>$pUrl</submitted-url>";

    if ($pTitle) {
      $lStatusMessage .= "<title>$pTitle</title>";
    }

    if ($pDescription) {
      $lStatusMessage .= "<description>$pDescription</description>";
    }

    if ($pPhoto) {
      $lStatusMessage .= "<submitted-image-url>$pPhoto</submitted-image-url>";
    }

    $lStatusMessage .= '</content>';
    $lStatusMessage .= '<visibility><code>anyone</code></visibility></share>';

    return $lStatusMessage;
  }
}
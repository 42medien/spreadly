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
  public function doPost($pActivity) {
  	$lToken = $this->getAuthToken();
  	if (!$lToken) {
      return false;
  	}

    $lStatusMessage = $this->generateShareMessage($pActivity);

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
  public static function generatePostMessage($pActivity) {
    sfProjectConfiguration::getActive()->loadHelpers(array('Text', 'Url', 'Tag'));

    $lHashtag = self::$aHashtags[$pActivity->getType()][$pActivity->getScore()];

    if ($pActivity->getTitle()) {
      $lTitle = $pActivity->getTitle();
    } else {
      $lTitle = parse_url ($pActivity->getUrl(), PHP_URL_HOST);
    }

    $lLink = link_to($lTitle, $pActivity->getUrlWithClickbackParam($this->onlineIdentity));

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
  public static function generateShareMessage($pActivity) {
    sfProjectConfiguration::getActive()->loadHelpers(array('Text', 'Url', 'Tag'));

    $lHashtag = self::$aHashtags[$pActivity->getType()][$pActivity->getScore()];
    $lUrl = $pActivity->getUrlWithClickbackParam($this->onlineIdentity);
    
    $lStatusMessage = '<?xml version="1.0" encoding="UTF-8"?><share>';
    $lStatusMessage .= "<comment>".$lHashtag."</comment>";
    $lStatusMessage .= '<content>';
    $lStatusMessage .= "<submitted-url>$lUrl</submitted-url>";

    if ($pActivity->getTitle()) {
      $lStatusMessage .= "<title>".$pActivity->getTitle()."</title>";
    }

    if ($pActivity->getDescr()) {
      $lStatusMessage .= "<description>".$pActivity->getDescr()."</description>";
    }

    if ($pActivity->getThumb()) {
      $lStatusMessage .= "<submitted-image-url>".$pActivity->getThumb()."</submitted-image-url>";
    }

    $lStatusMessage .= '</content>';
    $lStatusMessage .= '<visibility><code>anyone</code></visibility></share>';

    return $lStatusMessage;
  }
}

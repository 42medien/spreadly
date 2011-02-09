<?php
/**
 * Api to post twitter status messages
 *
 * @author Matthias Pfefferle
 */
class TwitterPostApiClient extends PostApi {

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

    $lStatusMessage = $this->generateMessage($pActivity);

    $lPostBody = array("status" => $lStatusMessage);
    $lConsumer = new OAuthConsumer(sfConfig::get("app_twitter_oauth_token"), sfConfig::get("app_twitter_oauth_secret"));
    $lStatus = OAuthClient::post($lConsumer, $lToken->getTokenKey(), $lToken->getTokenSecret(), "http://api.twitter.com/1/statuses/update.xml", $lPostBody, null, null, "http://twitter.com/");

    return $lStatus;
  }

  /**
   * generate Wildcard.. truncate if necessary, $pUrl is optional
   *
   * @param YiidActivity $pActivity
   * @return string
   */
  public static function generateMessage($pActivity) {
    sfProjectConfiguration::getActive()->loadHelpers('Text');
    
    $lUrl = ShortUrlTable::shortenUrl($pActivity->getUrlWithClickbackParam($this->onlineIdentity));

    $lMaxChars = 135;

    $lHashtag = self::$aHashtags[$pActivity->getType()][$pActivity->getScore()];
    $lText = $lUrl . " " . $lHashtag;
    $lLengthOfText = strlen($lText);

    if ($pActivity->getTitle()) {
      $lChars = $lMaxChars - $lLengthOfText;
      $lText = truncate_text($pActivity->getTitle(), $lChars, '...') . " " . $lText;
    }

    return $lText;
  }
}
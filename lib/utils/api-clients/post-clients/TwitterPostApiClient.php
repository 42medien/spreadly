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
  public function doPost(OnlineIdentity $pOnlineIdentity, $pUrl, $pType, $pScore, $pTitle = null, $pDescription = null, $pPhoto = null) {
    $lToken = AuthTokenTable::getByUserAndOnlineIdentity($pOnlineIdentity->getUserId(), $pOnlineIdentity->getId());
    if (!$lToken) {
      $pOnlineIdentity->setSocialPublishingEnabled(false);
      $pOnlineIdentity->save();
      return false;
    }

    $lUrl = ShortUrlTable::shortenUrl($pUrl);

    $lStatusMessage = $this->generateMessage($pType, $pScore, $lUrl, $pTitle);

    $lPostBody = array("status" => $lStatusMessage);
    $lConsumer = new OAuthConsumer(sfConfig::get("app_twitter_oauth_token"), sfConfig::get("app_twitter_oauth_secret"));
    $lStatus = OAuthClient::post($lConsumer, $lToken->getTokenKey(), $lToken->getTokenSecret(), "http://api.twitter.com/1/statuses/update.xml", $lPostBody, null, null, "http://twitter.com/");

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
  public static function generateMessage($pType, $pScore, $pUrl, $pTitle = null) {
    sfProjectConfiguration::getActive()->loadHelpers('Text');

    $lMaxChars = 135;

    $lHashtag = self::$aHashtags[$pType][$pScore];
    $lText = $pUrl . " " . $lHashtag;
    $lLengthOfText = strlen($lText);

    if ($pTitle) {
      $lChars = $lMaxChars - $lLengthOfText;
      $lText = truncate_text($lText, $lChars, '...') . " " . $lText;
    }

    return $lText;
  }
}
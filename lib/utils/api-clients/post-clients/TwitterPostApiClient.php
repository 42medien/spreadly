<?php
/**
 * Api to post twitter status messages
 *
 * @author Matthias Pfefferle
 */
class TwitterPostApiClient implements PostApiInterface {

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
  public function doPost(OnlineIdentity $pOnlineIdentity, $pUrl, $pType, $pScore, $pTitle, $pDescription, $pPhoto) {
    $lMaxChars = 135;

    $lOAuth = $pOnlineIdentity->getOAuthToken();
    $lOAuth = $lOAuth->convert();
    $lUrl  = ' - '.ShortUrlPeer::shortenUrl($pUrl);
    $lengthOfUrl = strlen($lUrl);

    $lStatusMessage = PostApiUtils::generateMessage($pType, $pScore, $pTitle, null, $lMaxChars-$lengthOfUrl);
    $lStatusMessage .= $lUrl;

    $lPostBody = array("status" => $lStatusMessage);
    $lOAuthConsumer = new OAuthConsumer(sfConfig::get("app_twitter_oauth_token"), sfConfig::get("app_twitter_oauth_secret"));
    $lStatus = OAuthClient::post($lOAuthConsumer, $lOAuth->key, $lOAuth->secret, "http://api.twitter.com/1/statuses/update.xml", $lPostBody);

    return $lStatus;
  }
}
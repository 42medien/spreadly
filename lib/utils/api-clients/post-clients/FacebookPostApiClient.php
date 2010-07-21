<?php
/**
 * Api to post facebook status messages
 *
 * @author Matthias Pfefferle
 */
class FacebookPostApiClient implements PostApiInterface {

  /**
   * defines the post function
   *
   * @param OnlineIdentity $pOnlineIdentity
   * @param string $pUrl if the url is not part of the message
   * @param string $pType
   * @param string $pScore
   * @param string $pMessage
   *
   * @return int status code
   */
  public function doPost(OnlineIdentity $pOnlineIdentity, $pUrl, $pType, $pScore, $pTitle) {
    $lOAuth = $pOnlineIdentity->getOAuthToken();
    $lStatusMessage = PostApiUtils::generateMessage($pType, $pScore, $pTitle);
    $lPostBody = "access_token=".$lOAuth->getTokenKey()."&message=".$lStatusMessage;

    if ($pUrl) {
      $lPostBody .= "&link=".$pUrl;
    }
    $lResponse = UrlUtils::sendPostRequest("https://graph.facebook.com/me/feed", $lPostBody);

    return $lResponse;
  }
}
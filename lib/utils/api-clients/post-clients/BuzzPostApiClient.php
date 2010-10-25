<?php
/**
 * Api to post google buzz status messages
 *
 * @author Matthias Pfefferle
 */
class BuzzPostApiClient extends PostApi {

  /**
   * defines the post function
   *
   * @param OnlineIdentity $pOnlineIdentity
   * @param string $pUrl if the url is not part of the message
   * @param string $pType
   * @param string $pScore
   * @return int status code
   */
  public function doPost(OnlineIdentity $pOnlineIdentity, $pUrl, $pType, $pScore) {
    /*$lUrl = "https://www.googleapis.com/buzz/v1/activities/@me/@self?alt=atom";
    $lPostBody = '<entry xmlns="http://www.w3.org/2005/Atom" xmlns:activity="http://activitystrea.ms/spec/1.0">';
    $lPostBody .= '<activity:object><activity:object-type>http://activitystrea.ms/schema/1.0/note</activity:object-type>';
    $lPostBody .= '<content type="html">'.$pStatusMessage.'<content>';
    $lPostBody .= '</activity:object></entry>';

    $lOAuth = $pOnlineIdentity->getOAuthToken();

    $lOAuth = $lOAuth->convert();
    $lOAuthConsumer = new OAuthConsumer("auth.yiid.com", "yxK3POFFf5S6dYPVZ2hSTr7V");
    $lOAuthRequest = OAuthClient::prepareRequest($lOAuthConsumer, $lOAuth, "POST", $lUrl);
    $lOAuthHeader = $lOAuthRequest->to_header();

    $lHeader = array("Content-Type: application/atom+xml");

    $lResponse = UrlUtils::sendPostRequest($lUrl, $lPostBody, $lHeader);

    return $lResponse;*/

    $lStatusMessage = "mag ".$pUrl;

    if ($pScore === -1) {
      $lStatusMessage .= " nicht";
    }

    return RpxClient::publishActivity($pOnlineIdentity->getAuthIdentifier(), $lStatusMessage, $pUrl, $lStatusMessage);
  }
}
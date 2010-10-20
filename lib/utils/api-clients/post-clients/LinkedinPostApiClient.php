<?php
/**
 * Api to post twitter status messages
 *
 * @author Matthias Pfefferle
 */
class LinkedinPostApiClient implements PostApiInterface {

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
    $lToken = AuthTokenTable::getByUserAndOnlineIdentity($pOnlineIdentity->getUserId(), $pOnlineIdentity->getId());
    if (!$lToken) {
      $pOnlineIdentity->setSocialPublishingEnabled(false);
      $pOnlineIdentity->save();
      return false;
    }

    $lMaxChars = 700;

    $lUrl  = ' - '.ShortUrlTable::shortenUrl($pUrl);
    $lengthOfUrl = strlen($lUrl);

    $lStatusMessage = '<activity locale="en_US"><content-type>linkedin-html</content-type><body>';
    $lStatusMessage .= htmlentities(PostApiUtils::generateMessage($pType, $pScore, $pTitle, null, $lMaxChars-$lengthOfUrl));
    $lStatusMessage .= '</body></activity>';

    $lPostBody = $lStatusMessage;
    $lConsumer = new OAuthConsumer(sfConfig::get("app_linkedin_oauth_token"), sfConfig::get("app_linkedin_oauth_secret"));
    $lStatus = OAuthClient::post($lConsumer, $lToken->getTokenKey(), $lToken->getTokenSecret(), "http://api.linkedin.com/v1/people/~/person-activities", $lPostBody, null, array("Content-Type: application/xml"), "http://api.linkedin.com");

    return $lStatus;
  }
}
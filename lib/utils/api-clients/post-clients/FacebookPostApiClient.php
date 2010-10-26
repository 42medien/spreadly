<?php
/**
 * Api to post facebook status messages
 *
 * @author Matthias Pfefferle
 */
class FacebookPostApiClient extends PostApi {

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
  public function doPost(OnlineIdentity $pOnlineIdentity, $pUrl, $pType, $pScore, $pTitle = null, $pDescription = null, $pPhoto = null) {
  	$lToken = AuthTokenTable::getByUserAndOnlineIdentity($pOnlineIdentity->getUserId(), $pOnlineIdentity->getId());
  	if (!$lToken) {
  	  $pOnlineIdentity->setSocialPublishingEnabled(false);
  	  $pOnlineIdentity->save();
      return false;
  	}

    $lStatusMessage = PostApiUtils::generateMessage($pType, $pScore, $pTitle);

    $lPostBody = "access_token=".$lToken->getTokenKey()."&message=".$lStatusMessage;

    if ($pDescription && $pDescription != '') {
      $lPostBody .= "&description=".$pDescription;
    }

    if ($pPhoto && $pPhoto != '') {
      $lPostBody .= "&picture=".$pPhoto;
    }

    if ($pUrl) {
      $lPostBody .= "&link=".urlencode($pUrl);
    }

    //$lPostBody .= '&privacy={"value": "EVERYONE"}';

    $lResponse = UrlUtils::sendPostRequest("https://graph.facebook.com/me/feed", $lPostBody);

    return $lResponse;
  }
}
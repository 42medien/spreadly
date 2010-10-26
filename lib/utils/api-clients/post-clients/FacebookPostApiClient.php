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

    $lStatusMessage = $this->generateMessage($pType, $pScore, $pTitle);

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

    $lPostBody .= '&privacy={"value": "EVERYONE"}';

    $lResponse = UrlUtils::sendPostRequest("https://graph.facebook.com/me/feed", $lPostBody);

    return $lResponse;
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
  public function generateMessage($pType, $pScore, $pTitle = null, $pUrl = null, $pMaxLength = null) {
    sfProjectConfiguration::getActive()->loadHelpers('Text');
    if ($pTitle) {
      $pTitle = '"'.$pTitle.'"';
    }

    $i18n = sfContext::getInstance()->getI18N();
    $lWildcard = 'POSTAPI_MESSAGE_'.strtoupper($pType) . ($pScore<0?'_NOT':'');
    if ($pMaxLength) {
      $lText = $i18n->__($lWildcard, array('%title%' => $pTitle, '%url%' => $pUrl), 'widget');
      $lText = truncate_text($lText, $pMaxLength , '...');
    } else {
      $lText = $i18n->__($lWildcard, array('%title%' => $pTitle, '%url%' => $pUrl), 'widget');
    }
    return $lText;
  }

}
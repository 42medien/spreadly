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
  public function doPost($pActivity) {
  	$lToken = AuthTokenTable::getByUserAndOnlineIdentity($this->onlineIdentity->getUserId(), $this->onlineIdentity->getId());

  	if (!$lToken) {
  	  $this->onlineIdentity->setSocialPublishingEnabled(false);
  	  $this->onlineIdentity->save();
      return false;
  	}

    $lStatusMessage = $this->generateMessage($pActivity);

    $lPostBody = "access_token=".$lToken->getTokenKey()."&message=".$lStatusMessage;

    if ($pActivity->getDescr() && $pActivity->getDescr() != '') {
      $lPostBody .= "&description=".$pActivity->getDescr();
    }

    if ($pActivity->getThumb() && $pActivity->getThumb() != '') {
      $lPostBody .= "&picture=".$pActivity->getThumb();
    }

    $lPostBody .= "&link=".urlencode($pActivity->getUrlWithClickbackParam($this->onlineIdentity));

    $lPostBody .= '&privacy={"value": "EVERYONE"}';

    $lResponse = UrlUtils::sendPostRequest("https://graph.facebook.com/me/feed", $lPostBody);

    return $lResponse;
  }


  /**
   * generate Wildcard.. truncate if necessary, $pUrl is optional
   *
   * @param YiidActivity $pActivity
   * @return string
   */
  private function generateMessage($pActivity) {
    $pTitle = $pActivity->getTitle();
    $pUrl = $pActivity->getUrlWithClickbackParam($this->onlineIdentity);
    
    sfProjectConfiguration::getActive()->loadHelpers('Text');
    if ($pTitle) {
      $pTitle = '"'.$pTitle.'"';
    }

    $i18n = sfContext::getInstance()->getI18N();
    $lWildcard = 'POSTAPI_MESSAGE_'.strtoupper($pActivity->getType()) . ($pActivity->getScore()e<0?'_NOT':'');
    $lText = $i18n->__($lWildcard, array('%title%' => $pTitle, '%url%' => $pUrl), 'widget');

    return $lText;
  }

}
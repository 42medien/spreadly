<?php
/**
 * Api to post facebook status messages
 *
 * @author Matthias Pfefferle
 */
class FacebookPostApiClient extends PostApi {

  /**
   * Need to override this method for facebook, since they use oauth2
   *
   */
  protected function send($pPostBody) {
    $lToken = $this->getAuthToken();
    $pPostBody .= "&access_token=".$lToken->getTokenKey();
    return UrlUtils::sendPostRequest(sfConfig::get("app_".$this->classToIdentifier()."_post_api"), $pPostBody);
  }

  /**
   * generate Wildcard.. truncate if necessary, $pUrl is optional
   *
   * @param YiidActivity $pActivity
   * @return string
   */
  private function generateMessage($pActivity) {
    $pTitle = $pActivity->getTitle();
    $pUrl = $pActivity->generateUrlWithClickbackParam($this->onlineIdentity);

    sfProjectConfiguration::getActive()->loadHelpers('Text');
    if ($pTitle) {
      $pTitle = '"'.$pTitle.'"';
    }

    $i18n = sfContext::getInstance()->getI18N();
    $lWildcard = 'POSTAPI_MESSAGE_'.strtoupper($pActivity->getType()) . ($pActivity->getScore()<0?'_NOT':'');
    $lText = $i18n->__($lWildcard, array('%title%' => $pTitle, '%url%' => $pUrl), 'widget');

    $lPostBody .= "message=".$lText;

    if ($pActivity->getDescr() && $pActivity->getDescr() != '') {
      $lPostBody .= "&description=".$pActivity->getDescr();
    }

    if ($pActivity->getThumb() && $pActivity->getThumb() != '') {
      $lPostBody .= "&picture=".$pActivity->getThumb();
    }

    $lPostBody .= "&link=".urlencode($pActivity->generateUrlWithClickbackParam($this->onlineIdentity));

    $lPostBody .= '&privacy={"value": "EVERYONE"}';
    
    return $lPostBody;
  }

}
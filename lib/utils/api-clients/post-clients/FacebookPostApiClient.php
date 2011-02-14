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
  protected function generateMessage($pActivity) {
    $lPostBody .= "message=".$pActivity->getComment();

    if ($pActivity->getDescr() && $pActivity->getDescr() != '') {
      $lPostBody .= "&description=".$pActivity->getDescr();
    }

    if ($pActivity->getTitle() && $pActivity->getTitle() != '') {
      $lPostBody .= "&name=".$pActivity->getTitle();
    }

    if ($pActivity->getThumb() && $pActivity->getThumb() != '') {
      $lPostBody .= "&picture=".$pActivity->getThumb();
    }

    $lPostBody .= "&link=".urlencode($pActivity->generateUrlWithClickbackParam($this->onlineIdentity));
    $lPostBody .= '&privacy={"value": "EVERYONE"}';

    if ($lDeal = $pActivity->getDeal()) {
      $i18n = sfContext::getInstance()->getI18N();
      $lPostBody .= '&actions={"name": "'.$i18n->__("Get the Deal").'", "link": "'.$lDeal->getDomainProfile()->getDomain().'"}';
    }

    return $lPostBody;
  }

}
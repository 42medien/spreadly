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
    // load activity or deal to fill the dummy object
    if ($pActivity->isDeal()) {
      $i18n = sfContext::getInstance()->getI18N();
      $lActionText = $i18n->__("Get the Deal");
      $lObject = $pActivity->getDeal();
    } else {
      $lActionText = "Spread";
      $lObject = $pActivity;
    }

    $lPostBody .= "message=".$pActivity->getComment();

    if ($lObject->getDescr() && $lObject->getDescr() != '') {
      $lPostBody .= "&description=".$lObject->getDescr();
    }

    if ($lObject->getTitle() && $lObject->getTitle() != '') {
      $lPostBody .= "&name=".$lObject->getTitle();
    }

    if ($lObject->getThumb() && $lObject->getThumb() != '') {
      $lPostBody .= "&picture=".$lObject->getThumb();
    }

    $lPostBody .= "&link=".urlencode($pActivity->generateUrlWithClickbackParam($this->onlineIdentity));
    $lPostBody .= '&privacy={"value": "EVERYONE"}';

    $lPostBody .= '&actions={"name": "'.$lActionText.'", "link": "'.sfConfig::get("app_settings_widgets_url").'/?url='.urlencode($pActivity->getUrl()).'"}';

    return $lPostBody;
  }

}
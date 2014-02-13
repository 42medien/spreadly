<?php
/**
 * Api to post facebook status messages
 *
 * @author Matthias Pfefferle
 */
class YiggPostApiClient extends PostApi {

  /**
   * generate Wildcard.. truncate if necessary, $pUrl is optional
   *
   * @param YiidActivity $pActivity
   * @return string
   */
  protected function generateMessage($pActivity) {
    $lPostBody = "message=".urlencode($pActivity->getDescr());
    $lPostBody .= "&name=".urlencode($lObject->getTitle());

    if ($lObject->getThumb() && $lObject->getThumb() != '') {
      $lPostBody .= "&photo=".urlencode($lObject->getThumb());
    }

    $lPostBody .= "&url=".urlencode($pActivity->getUrl());

    if ($pActivity->getTags()) {
      $lPostBody .= '&tags='.implode(",", $pActivity->getTags());
    }

    return $lPostBody;
  }

  protected function handleResponse($pResponse) {
    parent::handleResponse($pResponse);
    $lResponse = json_decode($pResponse, true);

    if (!array_key_exists("error", $lResponse)) {
      return;
    }

    $lError = new Documents\ApiErrorLog();

    $lError->setCode($lResponse['error']['code']);
    $lError->setMessage($lResponse['error']['message']);
    $lError->setOiId($this->onlineIdentity->getId());
    $lError->setUId($this->onlineIdentity->getUserId());
    $lError->save();

    //if (in_array($lResponse['error']['code'], array(190, 200, 450, 451, 452, 453, 454, 455))) {
    //  $this->onlineIdentity->deactivate();
    //}
  }
}
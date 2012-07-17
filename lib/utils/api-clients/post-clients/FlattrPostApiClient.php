<?php
/**
 * Api to post twitter status messages
 *
 * @author Matthias Pfefferle
 */
class FlattrPostApiClient extends PostApi {

  /**
   * generate Wildcard.. truncate if necessary, $pUrl is optional
   *
   * @param YiidActivity $pActivity
   * @return string
   */
  public function generateMessage($pActivity) {
    if ($pActivity->getDomainProfile() && $pActivity->getDomainProfile()->getFlattrAccount()) {
      $auto_submit = "http://flattr.com/submit/auto?url=".urlencode($pActivity->getUrl())."&user_id=".$pActivity->getDomainProfile()->getFlattrAccount();
      $json = json_encode(array("url" => $auto_submit));

      return $json;
    }
    
    return;
  }
  
  /**
   * Need to override this method for flattr, since they use oauth2
   */
  protected function send($pPostBody) {
    $lToken = $this->getAuthToken();
    
    if ($pPostBody) {
      return UrlUtils::sendPostRequest(sfConfig::get("app_".$this->classToIdentifier()."_post_api"), $pPostBody, array("Authorization: Bearer ".$lToken->getTokenKey(), "Content-type: application/json"));
    }
    
    return null;
  }

  protected function handleResponse($pResponse) {
    parent::handleResponse($pResponse);
    $lResponse = json_decode($pResponse, true);

    if (!array_key_exists("error", $lResponse)) {
      return;
    }

    $lError = new Documents\ApiErrorLog();

    $lError->setCode($lResponse['error']);
    $lError->setMessage($lResponse['error_description']);
    $lError->setOiId($this->onlineIdentity->getId());
    $lError->setUId($this->onlineIdentity->getUserId());
    $lError->save();

    if (strstr($lResponse['error'], "OAuth") !== false) {
      $this->onlineIdentity->deactivate();
    }
  }
}
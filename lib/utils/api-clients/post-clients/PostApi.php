<?php
/**
 * PostApi Interface
 *
 * @author Matthias Pfefferle
 */
abstract class PostApi {

  protected $onlineIdentity = null;

   /**
   * This method generates the message, that is suitable for posting to the actual network.
   *
   * @param YiidActivity $pActivity
   * @return string The message
   */
  abstract protected function generateMessage($pActivity);

  /**
   * Calls the generateMessage and send methods
   *
   * @param YiidActivity $pActivity
   * @return int status code
   */
  public function doPost($pActivity) {
    $lResponse = $this->send($this->generateMessage($pActivity));
    $this->handleResponse($lResponse);

    return $lResponse;
  }

  /**
   * default response handler. feel free to overwrite it!
   *
   * @param string $pResponse
   */
  protected function handleResponse($pResponse) {
    sfContext::getInstance()->getLogger()->notice("{PostApi Response} ".print_r($pResponse, true));
  }

  public function setOnlineIdentity($oi) {
    $this->onlineIdentity = $oi;
  }

  public function getOnlineIdentity() {
    return $this->onlineIdentity;
  }

  protected function getAuthToken() {
    $lToken = AuthTokenTable::getByUserAndOnlineIdentity($this->onlineIdentity->getUserId(), $this->onlineIdentity->getId());
    if (!$lToken) {
      $this->onlineIdentity->setSocialPublishingEnabled(false);
      $this->onlineIdentity->save();
    }
    return $lToken;
  }

  protected function classToIdentifier() {
    $class = get_class($this);
    $id = str_replace('PostApiClient', '', $class);
    return strtolower($id);
  }

  /**
   * Sends the message to the configured network
   *
   * @param string $pPostBody
   * @return mixed
   */
  protected function send($pPostBody) {
    $this->onlineIdentity->scheduleImportJob();
    $lToken = $this->getAuthToken();
    $lKey = sfConfig::get("app_".$this->classToIdentifier()."_oauth_token");
    $lSecret = sfConfig::get("app_".$this->classToIdentifier()."_oauth_secret");
    $lPostApi = sfConfig::get("app_".$this->classToIdentifier()."_post_api");
    $lPostRealm = sfConfig::get("app_".$this->classToIdentifier()."_post_realm");
    $lPostType = ($pt = sfConfig::get("app_".$this->classToIdentifier()."_post_type")) ? array($pt) : null;

    $lConsumer = new OAuthConsumer($lKey, $lSecret);

    return OAuthClient::post($lConsumer, $lToken->getTokenKey(), $lToken->getTokenSecret(), $lPostApi, $pPostBody, null, $lPostType, $lPostRealm);
  }
}

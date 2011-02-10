<?php
/**
 * PostApi Interface
 *
 * @author Matthias Pfefferle
 */
abstract class PostApi {
  public static $aHashtags = array("like" => array("1" => "#like", "-1" => "#dislike"),
                            "pro" => array("1" => "#pro", "-1" => "#contra"),
                            "recommend" => array("1" => "#recommend", "-1" => "#reject"),
                            "visit", array("1" => "#visit", "-1" => "#miss"),
                            "nice", array("1" => "#nice", "-1" => "#ugly"),
                            "buy", array("1" => "#buy", "-1" => "#dontbuy"),
                            "rsvp", array("1" => "#attend", "-1" => "#miss"));

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
  public function doPost($activity) {
    return $this->send($this->generateMessage($pActivity));
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
    $id = strstr($class, 'PostApiClient', true);
    return strtolower($id);
  }

  /**
   * Sends the message to the configured network
   *
   * @param string $pPostBody
   * @return mixed
   */
  protected function send($pPostBody) {
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

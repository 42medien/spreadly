http://www.youtube.com/watch?v=LUAZt0PFMQkhttp://www.youtube.com/watch?v=LUAZt0PFMQk<?php
/**
 * Api to post twitter status messages
 *
 * @author Matthias Pfefferle
 */
class TumblrPostApiClient extends PostApi {

  /**
   * generate Wildcard.. truncate if necessary, $pUrl is optional
   *
   * @param YiidActivity $pActivity
   * @return string
   */
  public function generateMessage($activity) {
    sfProjectConfiguration::getActive()->loadHelpers('Text');

    $post_body = array("tags"=>"spreadly,share", "type"=>"link", "state"=>"published", "tweet"=>"false");

    if ($activity->getComment() && $activity->getComment() != '') {
      $post_body["description"] = $activity->getComment();
    } else {
      $post_body["description"] = $activity->getDescr();
    }

    if ($activity->getTitle() && $activity->getTitle() != '') {
      $post_body["title"] = $activity->getTitle();
    }

    $post_body["url"] = $activity->generateUrlWithClickbackParam($this->onlineIdentity);

    return $post_body;
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
    $lPostApi = str_replace("{base-hostname}", $this->onlineIdentity->getName().".tumblr.com", $lPostApi);

    $oauth = new TumblrOAuth($lKey, $lSecret, $lToken->getTokenKey(), $lToken->getTokenSecret());

    return $oauth->post($lPostApi, $pPostBody);
  }

  protected function handleResponse($pResponse) {
    parent::handleResponse($pResponse);
  }
}
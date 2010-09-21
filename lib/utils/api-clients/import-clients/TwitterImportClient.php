<?php
require_once(dirname(__FILE__).'/../../../../config/ProjectConfiguration.class.php');

$configuration = ProjectConfiguration::getApplicationConfiguration('platform', 'batch', true);
sfContext::createInstance($configuration);

/**
 * Enter description here...
 *
 * @author Matthias Pfefferle
 */
class TwitterImportClient {

	public static function importContacts($pUserId, $pOnlineIdentity) {
    $lToken = AuthTokenTable::getByUserAndOnlineIdentity($pUserId, $pOnlineIdentity->getId());
    // get api informations
    $lConsumer = new OAuthConsumer(sfConfig::get("app_twitter_oauth_token"), sfConfig::get("app_twitter_oauth_secret"));
    $lJson = OAuthClient::get($lConsumer, $lToken->getTokenKey(), $lToken->getTokenSecret(), "http://api.twitter.com/1/friends/ids/".$pOnlineIdentity->getIdentifier().".json");
    $lJsonObject = json_decode($lJson);
    $lCommunityId = $pOnlineIdentity->getCommunityId();

    try {
	    foreach($lJsonObject as $lKey => $lValue) {
        $lContact = OAuthClient::get($lConsumer, $lToken->getTokenKey(), $lToken->getTokenSecret(), "http://api.twitter.com/1/users/show.json?user_id=".$lValue);
			  $lJsonUser = json_decode($lContact);
			  $lOnlineIdentity = OnlineIdentityTable::addOnlineIdentity($lJsonUser->screen_name, $lCommunityId);
			  if($lOnlineIdentity){
				  TwitterImportClient::completeOnlineIdentity($lOnlineIdentity, $lJsonUser);
				  $lOiCon = OnlineIdentityConTable::createNew($pOnlineIdentity->getId(), $lOnlineIdentity->getId());
			  }
			  sfContext::getInstance()->getLogger()->debug("onlineidentity: " . $lOnlineIdentity->getId());
	      sfContext::getInstance()->getLogger()->debug("oicon: " . $lOiCon->getId());
      }
    } catch (Exception $e) {
      sfContext::getInstance()->getLogger()->debug('[error]'.$e->getMessage());
    }
	}

  /**
   * complete the online-identity with the api json
   *
   * @param OnlineIdentity $pOnlineIdentity
   * @param Object $pObject
   */
  public static function completeOnlineIdentity($pOnlineIdentity, $pObject) {
    if ($pObject->name) {
      $pOnlineIdentity->setName($pObject->name);
    } else {
      $pOnlineIdentity->setName($pObject->screen_name);
    }
    $pOnlineIdentity->setPhoto($pObject->profile_image_url);
    $pOnlineIdentity->save();
  }

}
<?php
require_once(dirname(__FILE__).'/../../../../config/ProjectConfiguration.class.php');

$configuration = ProjectConfiguration::getApplicationConfiguration('platform', 'batch', true);
sfContext::createInstance($configuration);

/**
 * Enter description here...
 *
 * @author Matthias Pfefferle
 */
class FacebookImportClient {

  public static function importContacts($pUserId, $pOnlineIdentity) {
    $lToken = AuthTokenTable::getByUserAndOnlineIdentity($pUserId, $pOnlineIdentity->getId());
    if (!$lToken) {
      throw new Exception('damn theres no token!', '666');
    }
    $lConsumer = new OAuthConsumer(sfConfig::get("app_facebook_oauth_token"), sfConfig::get("app_facebook_oauth_secret"));
    $lJsonObject = json_decode(UrlUtils::sendGetRequest("https://graph.facebook.com/me/friends?access_token=".$lToken->getTokenKey()));
    $lCommunityId = $pOnlineIdentity->getCommunityId();

    try {
	    foreach ($lJsonObject->data as $lObject) {
	      $lOnlineIdentity = OnlineIdentityTable::addOnlineIdentity('http://facebook.com/profile.php?id='.$lObject->id, $lCommunityId);
	      if($lOnlineIdentity){
	        $lOiCon = OnlineIdentityConTable::createNew($pOnlineIdentity->getId(), $lOnlineIdentity->getId());
	      }
	    }
    } catch (Exception $e) { }
  }
}
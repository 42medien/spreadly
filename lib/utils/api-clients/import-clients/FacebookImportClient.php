<?php
require_once(dirname(__FILE__).'/../../../../config/ProjectConfiguration.class.php');

$configuration = ProjectConfiguration::getApplicationConfiguration('platform', 'batch', false);
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
      $pOnlineIdentity->setSocialPublishingEnabled(false);
      $pOnlineIdentity->save();
      throw new Exception('damn theres no token!', '666');
    }
    $lConsumer = new OAuthConsumer(sfConfig::get("app_facebook_oauth_token"), sfConfig::get("app_facebook_oauth_secret"));
    $lJsonObject = json_decode(UrlUtils::sendGetRequest("https://graph.facebook.com/me/friends?access_token=".$lToken->getTokenKey()));
    $lCommunityId = $pOnlineIdentity->getCommunityId();

    $lFriends = array();


    foreach ($lJsonObject->data as $lObject) {
      try {
        $lOnlineIdentity = OnlineIdentityTable::addOnlineIdentity($lJsonObject->link, $lJsonObject->id, $lCommunityId);
        $lFriends[] = $lOnlineIdentity->getId();
      } catch (Exception $e) {}
    }

    $pOnlineIdentity->setFriendIds(implode(",", $lFriends));
    $pOnlineIdentity->save();
  }
}
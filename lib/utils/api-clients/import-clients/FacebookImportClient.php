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

  public static function importContacts($pOnlineIdentity) {
    $lToken = AuthTokenTable::getByUserAndOnlineIdentity($pOnlineIdentity->getUserId(), $pOnlineIdentity->getId());
    if (!$lToken) {
      $pOnlineIdentity->setSocialPublishingEnabled(false);
      $pOnlineIdentity->save();
      throw new Exception('damn theres no token!', '666');
    }

    self::importFriends($pOnlineIdentity, $lToken);
    self::updateIdentity($pOnlineIdentity, $lToken);

  }


  public static function importFriends(&$pOnlineIdentity, $lToken) {
    $lJsonObject = json_decode(UrlUtils::sendGetRequest("https://graph.facebook.com/me/friends?access_token=".$lToken->getTokenKey()));
    $lCommunityId = $pOnlineIdentity->getCommunityId();

    $lFriends = array();
    foreach ($lJsonObject->data as $lObject) {
      try {
        //$lOnlineIdentity = OnlineIdentityTable::addOnlineIdentity($lObject->link, $lObject->id, $lCommunityId);
        $lFriends[] = $lObject->id;
      } catch (Exception $e) {}
    }

    $pOnlineIdentity->setFriendIds(implode(",", $lFriends));
    $pOnlineIdentity->setFriendCount(count($lFriends));

    $pOnlineIdentity->save();
  }


  public static function updateIdentity(&$pOnlineIdentity, $lToken) {
    $lJsonUserObject = json_decode(UrlUtils::sendGetRequest("https://graph.facebook.com/me?access_token=".$lToken->getTokenKey()."&locale=en_US"));

    $pOnlineIdentity->setName($lJsonUserObject->name);
    $pOnlineIdentity->setGender($lJsonUserObject->gender);

    // transform facebook format into
    $lBirthday = explode('/', $lJsonUserObject->birthday);
    if (count($lBirthday == 3 && $lBirthday[2] > 0)) { // 3 parts and year is set
      $pOnlineIdentity->setBirthdate($lBirthday[2].'-'.$lBirthday[0].'-'.$lBirthday[1]);
    }
    $pOnlineIdentity->setRelationshipState(IdentityHelper::tranformRelationshipStringToClasskey($lJsonUserObject->relationship_status));
    $pOnlineIdentity->setSocialPublishingEnabled(true);
    $pOnlineIdentity->setLocationRaw($lJsonUserObject->location->name);

    $pOnlineIdentity->save();

    // update user's email
    $lUser = $pOnlineIdentity->getUser();
    $lUser->setEmail($lJsonUserObject->email);
    $lUser->save();
  }
}
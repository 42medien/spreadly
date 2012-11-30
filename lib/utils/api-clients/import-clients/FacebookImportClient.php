<?php
/**
 * Enter description here...
 *
 * @author Matthias Pfefferle
 */
class FacebookImportClient {

  public static function importContacts($pOnlineIdentity) {
    $lToken = AuthTokenTable::getByUserAndOnlineIdentity($pOnlineIdentity->getUserId(), $pOnlineIdentity->getId());
    if (!$lToken) {
      $pOnlineIdentity->deactivate();
      throw new Exception('damn theres no token!', '666');
    }

    $lJsonUserObject = json_decode(UrlUtils::sendGetRequest("https://graph.facebook.com/me?access_token=".$lToken->getTokenKey()."&locale=en_US"));
    $lJsonFriendsObject = json_decode(UrlUtils::sendGetRequest("https://graph.facebook.com/me/friends?access_token=".$lToken->getTokenKey()));

    self::importFriends($pOnlineIdentity, $lJsonFriendsObject);
    self::updateIdentity($pOnlineIdentity, $lJsonUserObject);
  }

  /**
   * gather list of friends from facebook
   *
   * @param $pOnlineIdentity
   * @param $lToken
   * @return unknown_type
   */
  public static function importFriends(&$pOnlineIdentity, $lJsonObject) {
    $lFriends = array();
    foreach ($lJsonObject->data as $lObject) {
      try {
        $lFriends[] = $lObject->id;
      } catch (Exception $e) {}
    }

    $pOnlineIdentity->setFriendIds(implode(",", $lFriends));
    $pOnlineIdentity->setFriendCount(count($lFriends));

    $pOnlineIdentity->save();
  }

  /**
   * update the given online identity with latest data from facebook
   *
   * @param $pOnlineIdentity
   * @param $lToken
   * @return unknown_type
   */
  public static function updateIdentity(&$pOnlineIdentity, $lJsonUserObject) {
    $pOnlineIdentity->setName($lJsonUserObject->name);
    $pOnlineIdentity->setGender($lJsonUserObject->gender);

    // transform facebook format into
    $lBirthday = explode('/', $lJsonUserObject->birthday);
    if (count($lBirthday == 3 && $lBirthday[2] > 0 && $lBirthday[0] != '0000')) { // 3 parts and year is set
      $pOnlineIdentity->setBirthdate($lBirthday[2].'-'.$lBirthday[0].'-'.$lBirthday[1]);
    }
    $pOnlineIdentity->setRelationshipState(IdentityHelper::tranformRelationshipStringToClasskey($lJsonUserObject->relationship_status));
    $pOnlineIdentity->setSocialPublishingEnabled(true);
    $pOnlineIdentity->setLocationRaw($lJsonUserObject->location->name);

    $pOnlineIdentity->save();

    // update user's email
    $lUser = $pOnlineIdentity->getUser();
    if ($lJsonUserObject->email) {
      $lUser->setEmail($lJsonUserObject->email);
    }
    $lUser->setRelationshipState($pOnlineIdentity->getRelationshipState());
    $lUser->setBirthdate($pOnlineIdentity->getBirthDate());
    $lUser->save();
  }
	
	/**
	 * Imports all likes from a facebook account to store it in the mongodb
	 *
	 * @param int $online_identity
	 */
	public static function importLikes($online_identity) {
		$token = AuthTokenTable::getByUserAndOnlineIdentity($online_identity->getUserId(), $online_identity->getId());
		
    if (!$token) {
      $online_identity->deactivate();
      throw new Exception('damn theres no token!', '666');
    }
		
		
	}
}
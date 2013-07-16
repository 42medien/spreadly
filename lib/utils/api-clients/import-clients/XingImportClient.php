<?php
/**
 * class to import twitter contacts
 *
 * @author Matthias Pfefferle
 * @author Karina Mies
 */
class XingImportClient {
  /**
   * import twitter contacts
   *
   * @author Matthias Pfefferle
   * @author Karina Mies
   */
  public static function importContacts($pOnlineIdentity) {
    $lToken = AuthTokenTable::getByUserAndOnlineIdentity($pOnlineIdentity->getUserId(), $pOnlineIdentity->getId());
    // get api informations
    if (!$lToken) {
      $pOnlineIdentity->deactivate();
      throw new Exception('damn theres no token!', '666');
    }
    $lConsumer = new OAuthConsumer(sfConfig::get("app_xing_oauth_token"), sfConfig::get("app_xing_oauth_secret"));
    $lJson = OAuthClient::get($lConsumer, $lToken->getTokenKey(), $lToken->getTokenSecret(), "https://api.xing.com/v1/users/me/contact_ids.json");
    $lJsonFriendsObject = json_decode($lJson, true);

    sfContext::getInstance()->getLogger()->notice(print_r($lJsonFriendsObject, true));

    self::importFriends($pOnlineIdentity, $lJsonFriendsObject);
  }

  public static function importFriends(&$online_identity, $contacts) {
    if (isset($contacts["contact_ids"]) && isset($contacts["contact_ids"]["items"])) {
      $online_identity->setFriendIds(implode(",", $contacts["contact_ids"]["items"]));
      $online_identity->setFriendCount(count($contacts["contact_ids"]["items"]));
    }

    $online_identity->save();
  }
}
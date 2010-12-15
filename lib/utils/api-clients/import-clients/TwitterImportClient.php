<?php
/**
 * class to import twitter contacts
 *
 * @author Matthias Pfefferle
 * @author Karina Mies
 */
class TwitterImportClient {
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
      $pOnlineIdentity->setSocialPublishingEnabled(false);
      $pOnlineIdentity->save();
      throw new Exception('damn theres no token!', '666');
    }
    $lConsumer = new OAuthConsumer(sfConfig::get("app_twitter_oauth_token"), sfConfig::get("app_twitter_oauth_secret"));
    $lJson = OAuthClient::get($lConsumer, $lToken->getTokenKey(), $lToken->getTokenSecret(), "http://api.twitter.com/1/friends/ids/".$pOnlineIdentity->getOriginalId().".json");
    $lJsonFriendsObject = json_decode($lJson);

    // get api informations
    $lJson = OAuthClient::get($lConsumer, $lToken->getTokenKey(), $lToken->getTokenSecret(), "http://api.twitter.com/1/users/show.json?user_id=".$pOnlineIdentity->getOriginalId());
    $lJsonUserObject = json_decode($lJson);

    self::importFriends($pOnlineIdentity, $lJsonFriendsObject);
    self::updateIdentity($pOnlineIdentity, $lJsonUserObject);
  }

  public static function importFriends(&$pOnlineIdentity, $lJsonObject) {
    $pOnlineIdentity->setFriendIds(implode(",", $lJsonObject));
    $pOnlineIdentity->setFriendCount(count($lJsonObject));
    $pOnlineIdentity->save();
  }

  /**
   * update the given online identity with latest data from twitter
   *
   * @param $pOnlineIdentity
   * @param $lToken
   * @return unknown_type
   */
  public static function updateIdentity(&$pOnlineIdentity, $lJsonUserObject) {
    $lUser = UserTable::getInstance()->retrieveByPk($pOnlineIdentity->getUserId());

    if ($lJsonUserObject->name) {
      $pOnlineIdentity->setName($lJsonUserObject->name);
    } else {
      $pOnlineIdentity->setName($lJsonUserObject->screen_name);
    }

    // check for aggregating data of gender, birthday etc to complete user record
    // @todo proper location handling
    $pOnlineIdentity->setLocationRaw($lJsonUserObject->location);
  }
}
<?php
/**
 * PostApi Factory
 *
 * @author Matthias Pfefferle
 */
class PostApiFactory {
  public static function fromOnlineIdentityId($id) {
    $lOnlineIdentity = OnlineIdentityTable::getInstance()->find($id);

    $client = self::getClientByCommunityName($lOnlineIdentity->getCommunity()->getCommunity());
    $client->setOnlineIdentity($lOnlineIdentity);

    return $client;
  }

  public static function fromOnlineIdentityIdArray($ids) {
    $clients = array();
    foreach ($ids as $id) {
      $clients[] = self::fromOnlineIdentityId($id);
    }

    return $clients;
  }

  private static function getClientByCommunityName($lCommunity) {
    // return matching object
    switch ($lCommunity) {
      case "facebook":
        return new FacebookPostApiClient();
        break;
      case "twitter":
        return new TwitterPostApiClient();
        break;
      case "linkedin":
        return new LinkedinPostApiClient();
        break;
      case "google":
        return new GooglePostApiClient();
        break;
      case "tumblr":
        return new TumblrPostApiClient();
        break;
      case "xing":
        return new XingPostApiClient();
        break;
      default:
        return null;
    }
  }
}
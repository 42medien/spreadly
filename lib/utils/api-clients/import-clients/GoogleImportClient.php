<?php
/**
 * Enter description here...
 *
 * @author Matthias Pfefferle
 */
class GoogleImportClient {
  public static function importContacts($pOnlineIdentity) {
    $lToken = AuthTokenTable::getByUserAndOnlineIdentity($pOnlineIdentity->getUserId(), $pOnlineIdentity->getId());
    // get api informations
    if (!$lToken) {
      $pOnlineIdentity->setSocialPublishingEnabled(false);
      $pOnlineIdentity->save();
      throw new Exception('damn theres no token!', '666');
    }
    $lConsumer = new OAuthConsumer(sfConfig::get("app_google_oauth_token"), sfConfig::get("app_google_oauth_secret"));
    $lJson = OAuthClient::get($lConsumer, $lToken->getTokenKey(), $lToken->getTokenSecret(), "https://www.googleapis.com/buzz/v1/people/@me/@groups/@followers?max-results=100&alt=json");

    $lJsonObject = json_decode($lJson);

    $lFriends = array();

    foreach ($lJsonObject->data->entry as $lObject) {
      try {
        $lFriends[] = $lObject->id;
      } catch (Exception $e) {}
    }

    $pOnlineIdentity->setFriendIds(implode(",", $lFriends));
    $pOnlineIdentity->setFriendCount($lJsonObject->data->totalResults);
    $pOnlineIdentity->save();
  }
}
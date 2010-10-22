<?php
require_once(dirname(__FILE__).'/../../../../config/ProjectConfiguration.class.php');

$configuration = ProjectConfiguration::getApplicationConfiguration('platform', 'batch', true);
sfContext::createInstance($configuration);

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
    $lJsonObject = json_decode($lJson);

    $pOnlineIdentity->setFriendIds(implode(",", $lJsonObject));
    $pOnlineIdentity->save();

    /*
    // the twitter api allows access to 100 users
    // check how much rounds the script have to go to
    // get all
    $lFriendcount = count($lJsonObject);
    $lRounds = ceil($lFriendcount/100);

    if ($lRounds > 7) {
      $lRounds = 7;
    }



    // iterate through the results
    for ($i = 0; $i < $lRounds; $i++) {
      $lOffset = $i;
      $lIds = array_splice($lJsonObject, $lOffset, 100);

      // generate a string of comma separated twitter-ids
      $lIdString = implode(",", $lIds);
      // get matching users
      $lQueuePayload = serialize(array('oi' => $pOnlineIdentity->getId(), 'idstring' => $lIdString));
      AmazonSQSUtils::pushToQuque('TwitterContacts', $lQueuePayload);
    }

    */
    sfContext::getInstance()->getLogger()->info("{TwitterImportClient} ID ".$pOnlineIdentity->getId()." loaded and contacts sent to twitter import queue!!!!");
  }
}
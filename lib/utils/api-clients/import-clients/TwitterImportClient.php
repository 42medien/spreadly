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
  public static function importContacts($pUserId, $pOnlineIdentity) {
    $lToken = AuthTokenTable::getByUserAndOnlineIdentity($pUserId, $pOnlineIdentity->getId());
    // get api informations
    if (!$lToken) {
      throw new Exception('damn theres no token!', '666');
    }
    $lConsumer = new OAuthConsumer(sfConfig::get("app_twitter_oauth_token"), sfConfig::get("app_twitter_oauth_secret"));
    $lJson = OAuthClient::get($lConsumer, $lToken->getTokenKey(), $lToken->getTokenSecret(), "http://api.twitter.com/1/friends/ids/".$pOnlineIdentity->getIdentifier().".json");
    $lJsonObject = json_decode($lJson);
    $lCommunityId = $pOnlineIdentity->getCommunityId();

    // the twitter api allows access to 100 users
    // check how much rounds the script have to go to
    // get all
    $lFriendcount = count($lJsonObject);
    $lRounds = ceil($lFriendcount/100);

    /**
     * dirty hack
     *
     * @todo implement better solution
     */
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
      $lContacts = OAuthClient::get($lConsumer, $lToken->getTokenKey(), $lToken->getTokenSecret(), "http://api.twitter.com/1/users/lookup.json?user_id=".$lIdString);

      $lContacts = json_decode($lContacts);

      // save online-identities
      foreach ($lContacts as $lContact) {
        $lOnlineIdentity = OnlineIdentityTable::addOnlineIdentity($lContact->screen_name, $lCommunityId);

        if($lOnlineIdentity){
          $lOnlineIdentity->setPhoto($lContact->profile_image_url);
          $lOnlineIdentity->setName($lContact->screen_name);
          $lOnlineIdentity->save();

          sfContext::getInstance()->getLogger()->info("{TwitterImportClient} added online identity: " . $lOnlineIdentity->getId());

          try {
            $lOiCon = OnlineIdentityConTable::createNew($pOnlineIdentity->getId(), $lOnlineIdentity->getId());
          } catch (ModelException $e) {
            sfContext::getInstance()->getLogger()->err("{TwitterImportClient} " . $e->getMessage());
          }
        }
      }
    }

    sfContext::getInstance()->getLogger()->info("{TwitterImportClient} done!!!!");

    /*
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
     }*/
  }
}
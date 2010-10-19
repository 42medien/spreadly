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
class TwitterContactsImportClient {
  /**
   * import twitter contacts
   *
   * @author Matthias Pfefferle
   * @author Karina Mies
   * @author weyandch
   */
  public static function import($pMessage) {
    $lPayload = unserialize($pMessage[0]['Body']);

    $lOiId = $lPayload['oi'];
    $lIdString = $lPayload['idstring'];
    $pOnlineIdentity = OnlineIdentityTable::getInstance()->retrieveByPk($lOiId);
    if (!$pOnlineIdentity) {
      return false;
    }
    $lUserId = $pOnlineIdentity->getUserId();
    $lCommunityId = $pOnlineIdentity->getCommunityId();

    $lToken = AuthTokenTable::getByUserAndOnlineIdentity($lUserId, $pOnlineIdentity->getId());
    // get api informations
    if (!$lToken) {
      $pOnlineIdentity->setSocialPublishingEnabled(false);
      $pOnlineIdentity->save();
      return false;
    }

    $lConsumer = new OAuthConsumer(sfConfig::get("app_twitter_oauth_token"), sfConfig::get("app_twitter_oauth_secret"));

    // get matching users
    $lContacts = OAuthClient::get($lConsumer, $lToken->getTokenKey(), $lToken->getTokenSecret(), "http://api.twitter.com/1/users/lookup.json?user_id=".$lIdString);

    $lContacts = json_decode($lContacts);

    // save online-identities
    foreach ($lContacts as $lContact) {
      $lOnlineIdentity = OnlineIdentityTable::addOnlineIdentity("http://twitter.com/".$lContact->screen_name, $lContact->id, $lCommunityId);

      if($lOnlineIdentity){
        $lOnlineIdentity->setPhoto($lContact->profile_image_url);
        $lOnlineIdentity->setName($lContact->screen_name);
        $lOnlineIdentity->save();

        sfContext::getInstance()->getLogger()->info("{TwitterImportClient} added online identity: " . $lOnlineIdentity->getId());
      }

    }

    sfContext::getInstance()->getLogger()->info("{TwitterImportClient} done!!!!");
  }
}
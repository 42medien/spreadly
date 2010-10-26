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
class LinkedinImportClient {
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
    $lConsumer = new OAuthConsumer(sfConfig::get("app_linkedin_oauth_token"), sfConfig::get("app_linkedin_oauth_secret"));
    $lXml = OAuthClient::get($lConsumer, $lToken->getTokenKey(), $lToken->getTokenSecret(), "http://api.linkedin.com/v1/people/~/connections:(id)");

    $lObject = simplexml_load_string($lXml);

    $lArray = array();

    foreach ($lObject->person as $lPerson) {
      $lArray[] = $lPerson->id;
    }

    $pOnlineIdentity->setFriendIds(implode(",", $lArray));
    $pOnlineIdentity->setFriendCount(count($lArray));
    $pOnlineIdentity->save();

    sfContext::getInstance()->getLogger()->info("{TwitterImportClient} ID ".$pOnlineIdentity->getId()." loaded and contacts sent to twitter import queue!!!!");
  }
}
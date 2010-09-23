<?php
// required because its called like a batch outside of the symfony context
require_once(dirname(__FILE__).'/../../../../config/ProjectConfiguration.class.php');

$configuration = ProjectConfiguration::getApplicationConfiguration('platform', 'batch', true);
sfContext::createInstance($configuration);

/**
 * class to import the contacts from an online identity
 *
 * @author Matthias Pfefferle
 */
class YiidImportContacts {
  public static function import($pMessage) {
    $lOnlineIdentity = OnlineIdentityTable::getInstance()->find($pMessage[0]['Body']);

    if ($lOnlineIdentity) {
      $lOnlineIdentity->setLastFriendRefresh(now());
      $lOnlineIdentity->save();
      try {
        $lObject = ImportApiFactory::factory($lOnlineIdentity->getCommunityId());
        $lObject->importContacts($lOnlineIdentity->getUserId(), $lOnlineIdentity);
      } catch (Exception $e) {
        sfContext::getInstance()->getLogger()->err("{Daemon} ImpotContacts: " . $e->getMessage());
      }
    }
  }
}
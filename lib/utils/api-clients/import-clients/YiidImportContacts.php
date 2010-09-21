<?php
require_once(dirname(__FILE__).'/../../../../config/ProjectConfiguration.class.php');

$configuration = ProjectConfiguration::getApplicationConfiguration('platform', 'batch', true);
sfContext::createInstance($configuration);

/**
 * Enter description here...
 *
 * @author Matthias Pfefferle
 */
class YiidImportContacts {
  public static function import($pMessage) {
    sfContext::getInstance()->getLogger()->debug("{YiidImportContacts} Debug: " . print_r($pMessage, true));

    $lOnlineIdentity = OnlineIdentityTable::getInstance()->find($pMessage[0]['Body']);

    if ($lOnlineIdentity) {
      $lObject = ImportApiFactory::factory($lOnlineIdentity->getCommunityId());
      $lObject->importContacts($lOnlineIdentity->getUserId(), $lOnlineIdentity);
    }
  }
}
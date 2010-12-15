<?php
/**
 * class to import the contacts from an online identity
 *
 * @author Matthias Pfefferle
 */
class YiidImportContacts {
  public static function import($pMessage) {
    $lOnlineIdentity = OnlineIdentityTable::getInstance()->find($pMessage[0]['Body']);
    sfContext::getInstance()->getLogger()->debug("{Daemon} ImportContacts: ". $pMessage[0]['Body']);
    if ($lOnlineIdentity) {
      $lOnlineIdentity->setLastFriendRefresh(time());
      $lOnlineIdentity->save();
      try {
        $lObject = ImportApiFactory::factory($lOnlineIdentity->getCommunityId());
        if ($lObject) {
          $lObject->importContacts($lOnlineIdentity);
        }
      } catch (Exception $e) {
        sfContext::getInstance()->getLogger()->err("{Daemon} ImportContacts: " . $e->getMessage());
      }
    }
  }
}
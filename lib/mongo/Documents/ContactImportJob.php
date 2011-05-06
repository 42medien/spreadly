<?php
namespace Documents;
use \OnlineIdentityTable,
    \ImportApiFactory,
    \sfContext,
    \Exception;
/**
 * ContactImportJob
 * @Document
 * @author Hannes Schippmann
 */
class ContactImportJob extends Job {
  
  /** @String */
  private $onlineIdentityId;

  public function __construct($onlineIdentityId) {
   $this->onlineIdentityId = $onlineIdentityId;
  }

  public function execute() {
    $lOnlineIdentity = OnlineIdentityTable::getInstance()->find($this->onlineIdentityId);
    sfContext::getInstance()->getLogger()->notice("{ContactImportJob} importing for oi_id: ". $this->onlineIdentityId);
    
    if ($lOnlineIdentity){
      $lOnlineIdentity->setLastFriendRefresh(time());
      $lOnlineIdentity->save();
      try {
        $lObject = ImportApiFactory::factory($lOnlineIdentity->getCommunityId());
        if ($lObject) {
          $lObject->importContacts($lOnlineIdentity);
        }
      } catch (Exception $e) {
        sfContext::getInstance()->getLogger()->err("{ContactImportJob} importing failed: " . $e->getMessage());
      }
    }
  }
}
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
  private $online_identity_id;

  public function __construct($online_identity_id) {
   $this->online_identity_id = $online_identity_id;
  }

  public function execute() {
    $lOnlineIdentity = OnlineIdentityTable::getInstance()->find($this->online_identity_id);
    sfContext::getInstance()->getLogger()->notice("{ContactImportJob} importing for oi_id: ". $this->online_identity_id);
    
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
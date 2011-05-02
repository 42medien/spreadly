<?php
/**
 * ContactImportJob
 *
 * @author Hannes Schippmann
 */
abstract class ContactImportJob {
  private $onlineIdentityId;
  
  public function __construct($onlineIdentityId) {
   parent::__construct(); 
   $this->onlineIdentityId = $onlineIdentityId;
  }
  
  public function fromArray($array) {
    $this->onlineIdentityId = $array['onlineIdentiyId'];
  }

  public function toArray() {
    return array('onlineIdentityId' => $this->onlineIdentityId, 'type' => $this->type);
  }
  
  public function execute() {
    $lOnlineIdentity = OnlineIdentityTable::getInstance()->find($this->onlineIdentityId);
    sfContext::getInstance()->getLogger()->debug("{Daemon} ImportContacts: ". $this->onlineIdentityId);
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

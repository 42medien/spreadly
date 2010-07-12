<?php
class MemcacheListener extends Doctrine_Record_Listener
{
  /**
   * Enter description here...
   *
   */
  public function postSave(Doctrine_Event $pEvent) {
    try {
      $lInvoker = $pEvent->getInvoker();

      $lSuccess = MemcacheManager::getInstance()->getCache()->set($lInvoker->getMemcacheId(), serialize($lInvoker));
      if ($lSuccess) {
        sfContext::getInstance()->getLogger()->info('{yiidMemCache} saved User '. $lInvoker->getMemcacheId());
      }
    } catch (Exception $e) {}
  }
}
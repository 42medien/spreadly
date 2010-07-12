<?php
/**
 * listener vor memcache hooks
 *
 * @author Matthias Pfefferle
 */
class MemcacheListener extends Doctrine_Record_Listener {
  /**
   * adds object to memcache after saving it
   *
   * @author Matthias Pfefferle
   * @param Doctrine_Event $pEvent
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

  /**
   * deletes object from memcache before deleting it from the db
   *
   * @author Matthias Pfefferle
   * @param Doctrine_Event $pEvent
   */
  public function preDelete(Doctrine_Event $pEvent) {
    $lInvoker = $pEvent->getInvoker();

    MemcacheManager::getInstance()->getCache()->remove($lInvoker->getMemcacheId());
  }
}
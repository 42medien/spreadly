<?php
/**
 * memcache behavior
 *
 * @author Matthias Pfefferle
 */
class MemcacheBehavior extends Doctrine_Template {
  /**
   * generates an objects memcache-id
   *
   * @author Matthias Pfefferle
   * @return string
   */
  public function getMemcacheId() {
    $lInvoker = $this->getInvoker();

    return strtolower(get_class($lInvoker)) . "-" . $lInvoker->getId();
  }

  public function setTableDefinition() {
    $this->addListener(new MemcacheListener());
  }

  /**
   * Retrieves data from memcache.
   *
   * @param string Memcache key to use.
   * @return object|null
   */
  public static function getFromMemcache($pKey) {
    // try to get memcahe object
    try {
      $lObject = MemcacheManager::getInstance()->getCache()->get($pKey);
      // if available return memcache object
      if ($lObject) {
        sfContext::getInstance()->getLogger()->info('{yiidMemCache} found User '. $pKey);
        return unserialize($lObject);
      }
      // else return null
    } catch (Exception $e) {
      return null;
    }
    return null;
  }

  public function retrieveByPkTableProxy($pPk) {
    $lInvoker = $this->getInvoker();

    $lClassName = get_class($lInvoker);

    $lObject = null;
    $lMemcacheId = strtolower($lClassName) . "-" . $pPk;

    // first try GLOBALS cache
    if (isset($GLOBALS['CACHE'][strtoupper($lClassName)][$pPk])) {
      $lObject = $GLOBALS['CACHE'][strtoupper($lClassName)][$pPk];
      if ($lObject) {
        $cache = 'yiidGlobalCache';
        try {
          sfContext::getInstance()->getLogger()->info('{yiidGlobalCache} found a '. $lClassName .' with id ' . $pPk . ' in '.$cache);
        } catch(Exception $e) {}
      }
    } else {// if not found try memcached
      $lObject = self::getFromMemcache($lMemcacheId);
    }

    if ($lObject) {
      // store in GLOBALS cache
      $GLOBALS['CACHE'][strtoupper($lClassName)][$pPk] = $lObject;
      return $lObject;
    } else {
      $lObject = $lInvoker->getTable()->find($pPk);
      if ($lObject) {
        MemcacheManager::getInstance()->getCache()->set($lMemcacheId, serialize($lObject));
        $GLOBALS['CACHE'][strtoupper($lClassName)][$pPk] = $lObject;
        return $lObject;
      } else {
        return null;
      }
    }
  }
}
?>
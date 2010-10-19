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

  /**
   * adds listener with memcache hooks
   *
   * @author Matthias Pfefferle
   */
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
        $lObject = unserialize($lObject);
        sfContext::getInstance()->getLogger()->info('{yiidMemCache} found '.get_class($lObject) . " " . $pKey);
        return $lObject;
      }
      // else return null
    } catch (Exception $e) {
      return null;
    }
    return null;
  }

  /**
   * use our memcache instead database when calling method
   *
   * @author Matthias Pfefferle
   * @param int $pPk
   * @return array of user objects
   */
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
      }
    } else {// if not found try memcached
      $lObject = self::getFromMemcache($lMemcacheId);
      $cache = 'yiidMemcache';
    }

    if ($lObject) {
      try {
        sfContext::getInstance()->getLogger()->info('{yiidGlobalCache} found a '. $lClassName .' with id ' . $pPk . ' in '.$cache);
      } catch(Exception $e) {}
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

  /**
   * use our memcache instead database when calling method
   *
   * @author Christian Weyand
   * @author Matthias Pfefferle
   * @param array $pPks
   * @return array of user objects
   */
  public function retrieveByPKsTableProxy($pPks) {
    $lObjects = null;
    if (empty($pPks)) {
      $lObjects = array();
    } else {
      foreach ($pPks as $lPk) {
        $lObject = $this->retrieveByPkTableProxy($lPk);
        if ($lObject) {
          $lObjects[] = $lObject;
        }
      }
    }
    return $lObjects;
  }
}
?>
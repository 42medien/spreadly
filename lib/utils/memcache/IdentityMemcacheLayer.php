<?php
/**
 * memcache behavior
 *
 * @author Matthias Pfefferle
 */
class IdentityMemcacheLayer {
  /**
   * generates an objects memcache-id
   *
   * @author Matthias Pfefferle
   * @return string
   */
  public static function getMemcacheId($pUserId) {
    return 'user_oi_' . $pUserId;
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
        sfContext::getInstance()->getLogger()->info('{yiidMemCache} found data for User: '. $pKey);
        return $lObject;
      }
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
  public static function retrieveByUserId($pUserId) {
    $lMemcacheId = self::getMemcacheId($pUserId);

    // retrieve from memcache
    $lObject = self::getFromMemcache($lMemcacheId);

    if ($lObject) {
      return $lObject;
    } else {
      $lObject = array();

      $lObject['user_ids'] = array();
      $lObject['oi_ids'] = array();

      $lObject = array_merge($lObject, UserTable::retrieveFriendConnectionsForMemcache($pUserId));
      MemcacheManager::getInstance()->getCache()->set($lMemcacheId, serialize($lObject), sfConfig::get('app_settings_memcache_userlifetime', 86400));
      return $lObject;
    }
  }


  public static function retrieveContactUserIdsByUserId($pUserId) {
    $lObject = self::retrieveByUserId($pUserId);
    return $lObject['user_ids'];
  }

  public static function retrieveContactOiIdsByUserId($pUserId) {
    $lObject = self::retrieveByUserId($pUserId);
    return $lObject['oi_ids'];
  }


}
?>
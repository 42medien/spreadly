<?php

require_once(SF_ROOT_DIR.'/lib/model/doctrine/SocialObjectTable.class.php');
class BatchSocialObjetTable extends SocialObjectTable {

  /**
   * Clears whole Database (buildlocal/dev) - not for production!
   *
   * @author Christian Weyand
   * @param boolean $pAreYouSure
   * @deprecated don't use this in production!
   */
  public static function doRemoveAll($pAreYouSure = false) {
    if ($pAreYouSure) {
      $lCollection = self::getMongoCollection();
      return $lResults = $lCollection->remove();
    }
    return false;
  }

}

class BatchYiidActivityTable extends YiidActivityTable {

  /**
   * Clears whole Database (buildlocal/dev) - not for production!
   *
   * @author Christian Weyand
   * @param boolean $pAreYouSure
   * @deprecated don't use this in production!
   */
  public static function doRemoveAll($pAreYouSure = false) {
    if ($pAreYouSure) {
      $lCollection = self::getMongoCollection();
      return $lResults = $lCollection->remove();
    }
    return false;
  }

}



class BatchSessionStorage {


  const MONGO_COLLECTION_NAME = 'session';

  public static function getMongoCollection() {
    return MongoDbConnector::getInstance()->getCollection(sfConfig::get('app_mongodb_database_name'), self::MONGO_COLLECTION_NAME);
  }

  /**
   * Clears whole Database (buildlocal/dev) - not for production!
   *
   * @author Christian Weyand
   * @param boolean $pAreYouSure
   * @deprecated don't use this in production!
   */
  public static function doRemoveAll($pAreYouSure = false) {
    if ($pAreYouSure) {
      $lCollection = self::getMongoCollection();
      return $lResults = $lCollection->remove();
    }
    return false;
  }
}

?>
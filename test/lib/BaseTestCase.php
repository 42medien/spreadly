<?php

require_once 'PHPUnit/Framework.php';
define('SF_ROOT_DIR', realpath(dirname(__FILE__).'/../..'));

require_once(SF_ROOT_DIR.'/config/ProjectConfiguration.class.php');

new sfDatabaseManager(ProjectConfiguration::getApplicationConfiguration('platform', 'test', true));
sfContext::createInstance(ProjectConfiguration::getApplicationConfiguration('platform', 'test', true));


/**
 * adds lib folder to code-coverage
 * removes symfony-generated files from code-coverage
 */
PHPUnit_Util_Filter::addDirectoryToWhitelist( SF_ROOT_DIR.DIRECTORY_SEPARATOR.'lib/', '.php');
PHPUnit_Util_Filter::removeDirectoryFromWhitelist(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'lib/model/doctrine/base/');
PHPUnit_Util_Filter::removeDirectoryFromWhitelist(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'lib/helper/');
PHPUnit_Util_Filter::removeDirectoryFromWhitelist(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'lib/form/');
PHPUnit_Util_Filter::removeDirectoryFromWhitelist(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'lib/filter/');
PHPUnit_Util_Filter::removeDirectoryFromWhitelist(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'lib/vendor/');
PHPUnit_Util_Filter::removeDirectoryFromWhitelist(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'lib/exceptions/');

/**
 * abstract class to provide global functions for the tests
 */
abstract class BaseTestCase extends PHPUnit_Framework_TestCase{
  /**
   * resets the database
   */
  public function resetDB() {
    //Doctrine::loadData(SF_ROOT_DIR.'/data/sql/fixtures');
  }

  public static function resetMongo() {
    BatchSocialObjetTable::doRemoveAll(true);
    BatchYiidActivityTable::doRemoveAll(true);
    BatchSessionStorage::doRemoveAll(true);
  }
}


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

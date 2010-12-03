<?php
define('SF_ROOT_DIR', realpath(dirname(__FILE__).'/../..'));

require_once(SF_ROOT_DIR.'/config/ProjectConfiguration.class.php');

new sfDatabaseManager(ProjectConfiguration::getApplicationConfiguration('platform', 'dev', true));
sfContext::createInstance(ProjectConfiguration::getApplicationConfiguration('platform', 'dev', true));

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
    MongoDbConnector::getInstance()->getDatabase("yiid")->drop();
  }
}
?>

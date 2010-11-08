<?php

require_once(dirname(__FILE__).'/../../config/ProjectConfiguration.class.php');

$configuration = ProjectConfiguration::getApplicationConfiguration('platform', 'prod', true);

sfContext::createInstance($configuration);

$logger = sfContext::getInstance()->getLogger();

// Initialize database manager.
$dbManager = new sfDatabaseManager($configuration);
$dbManager->loadConfiguration();


/**
 *  we need all user id's first
 **/

$lActivities = YiidActivityTable::retrieveAllObjects();


/****
 *
 *
 * avatar migration
 *
 * email migration
 *
 * ..???
 */
echo "######################################### \r\n";
echo "Start migration: 01_identitys.php \r\n";
echo "######################################### \r\n";

foreach ($lActivities as $lActivity) {
  echo $lActivity->getUrl()."\r\n";
  $lUser = UserTable::getInstance()->retrieveByPk($lActivity->getUId());
  StatsFeeder::feed($lActivity, $lUser);
}
echo "######################################### \r\n";
echo "End migration: 01_useravatar.php \r\n";
echo "######################################### \r\n";
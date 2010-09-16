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
$lQuery = Doctrine_Query::create()->from('User u')->limit(500)->where('u.done = ?', 0);
$lIds = $lQuery->fetchArray();
$lQuery->free();

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
echo "Start migration: 08_userfriends.php \r\n";
echo "######################################### \r\n";
foreach ($lIds as $key => $value) {
  UserRelationTable::doIdentityMigration($value['id']);
  $lUser = UserTable::getInstance()->retrieveByPk($value['id']);
  $lUser->setDone(1);
  $lUser->save();
  echo $value['id']."\r\n";
}
echo "######################################### \r\n";
echo "End migration: 01_useravatar.php \r\n";
echo "######################################### \r\n";
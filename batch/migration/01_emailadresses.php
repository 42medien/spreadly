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
$lQuery = Doctrine_Query::create()->from('User u')->select('u.id')->andWhere('u.email IS NULL');
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
echo "Start migration: 01_useravatar.php \r\n";
echo "######################################### \r\n";
foreach ($lIds as $key => $value) {
  try{
	  $lUser = UserTable::getInstance()->retrieveByPk($value['id']);
	  //if user has a avatar in general
echo $lUser->getUsername()."\r\n";
  } catch(Exception $e){
    echo $e->getMessage();
    continue;
  }
}
echo "######################################### \r\n";
echo "End migration: 01_useravatar.php \r\n";
echo "######################################### \r\n";
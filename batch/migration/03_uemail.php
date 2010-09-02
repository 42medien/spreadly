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
$lQuery = Doctrine_Query::create()->from('User u')->select('u.id');
$lIds = $lQuery->fetchArray();
$lQuery->free();


foreach ($lIds as $key => $value) {
  $lUser = UserTable::getInstance()->retrieveByPk($value['id']);
	$lUserEmail = UserEmailAddressTable::getMainAddresses($value['id']);
	$lUser->setEmail($lUserEmail->getEmail());
	$lUser->save();
}
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

echo "######################################### \r\n";
echo "Start migration: 03_uemail.php \r\n";
echo "######################################### \r\n";
foreach ($lIds as $key => $value) {
	try{
	  $lUser = UserTable::getInstance()->retrieveByPk($value['id']);
	  echo "Userid: ".$value['id'] ;
		$lUserEmail = UserEmailAddressTable::getMainAddresses($value['id']);
		$lUser->setEmail($lUserEmail->getEmail());
		$lUser->save();
		echo " got email: ".$lUserEmail->getEmail()." with id: ".$lUserEmail->getId()."\n\r";
  } catch(Exception $e){
    echo $e->getMessage();
    continue;
  }

}
echo "######################################### \r\n";
echo "End migration: 03_uemail.php \r\n";
echo "######################################### \r\n";
echo "\r\n";
echo "\r\n";
echo "\r\n";
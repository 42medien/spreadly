<?php

require_once(dirname(__FILE__).'/../../config/ProjectConfiguration.class.php');

$configuration = ProjectConfiguration::getApplicationConfiguration('platform', 'prod', true);

sfContext::createInstance($configuration);

$logger = sfContext::getInstance()->getLogger();

// Initialize database manager.
$dbManager = new sfDatabaseManager($configuration);
$dbManager->loadConfiguration();


echo "######################################### \r\n";
echo "Start migration: 04_oidentity.php \r\n";
echo "######################################### \r\n";
$lUiCons = UserIdentityConTable::getVerified();
foreach ($lUiCons as $key => $value) {
	try{
	  $lOi = OnlineIdentityTable::getInstance()->retrieveByPk($value['online_identity_id']);
	  if(!$lOi->getUserId()) {
		  $lOi->setUserId($value['user_id']);
		  $lOi->save();
		  echo "Oiid: ".$lOi->getId()." got userid: ".$value['user_id']."\n\r";
	  }
	} catch(Exception $e){
    echo $e->getMessage();
    continue;
	}
}
echo "######################################### \r\n";
echo "End migration: 04_oidentity.php \r\n";
echo "######################################### \r\n";
echo "\r\n";
echo "\r\n";
echo "\r\n";
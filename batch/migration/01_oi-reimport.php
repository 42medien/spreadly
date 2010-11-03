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
$lQuery = Doctrine_Query::create()->from('OnlineIdentity oi')->select('oi.id');
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
echo "Start migration: 01_identitys.php \r\n";
echo "######################################### \r\n";

foreach ($lIds as $key => $value) {
  try{

    AmazonSQSUtils::pushToQuque("ImportContacts", $value['id']);
    echo "oi: ".$value['id']."\r\n";

  } catch(Exception $e){
    echo $e->getMessage();
    continue;
  }
}
echo "######################################### \r\n";
echo "End migration: 01_useravatar.php \r\n";
echo "######################################### \r\n";
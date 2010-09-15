<?php

require_once(dirname(__FILE__).'/../../config/ProjectConfiguration.class.php');

$configuration = ProjectConfiguration::getApplicationConfiguration('platform', 'prod', true);

sfContext::createInstance($configuration);

$logger = sfContext::getInstance()->getLogger();

// Initialize database manager.
$dbManager = new sfDatabaseManager($configuration);
$dbManager->loadConfiguration();

$lM = new Mongo('192.168.1.190'); // connect
$lDb = $lM->selectDB("yiid_stats");

$lMongoCursor = $lDb->selectCollection('clicks')->find()->limit(5000000);
$lErros = 0;
$i=0;
foreach ($lMongoCursor as $lVisit) {
if ($lVisit['host'] != '') {
  echo $i++;
  echo"\r\n";
  YiidStatsSingleton::trackClickForMigration($lVisit['host'],  $lVisit['score'],  $lVisit['c']);
} else { $lErros++; }

}

echo $lErros;
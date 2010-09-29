<?php

require_once(dirname(__FILE__).'/../../config/ProjectConfiguration.class.php');

$configuration = ProjectConfiguration::getApplicationConfiguration('platform', 'prod', true);

sfContext::createInstance($configuration);

$logger = sfContext::getInstance()->getLogger();

// Initialize database manager.
$dbManager = new sfDatabaseManager($configuration);
$dbManager->loadConfiguration();

$lM = new Mongo(sfConfig::get('app_mongodb_host')); // connect
$lDb = $lM->selectDB(sfConfig::get('app_mongodb_database_name_stats'));

$lMongoCursor = $lDb->selectCollection('visits')->find()->limit(100000)->sort(array('c' => -1));
$lErros = 0;
$i=0;

  foreach ($lMongoCursor as $lVisit) {

    if ($lVisit['host'] != '') {
      echo $i++;
      echo"\r\n";
      $lDb->selectCollection('visits')->remove(array('_id' => new MongoId($lVisit['_id'])), array('$atomic' => 1));
      YiidStatsSingleton::trackVisitForMigration($lVisit['host'], $lVisit['c']);
    } else {

      $lDb->selectCollection('visits')->remove(array('_id' => new MongoId($lVisit['_id'])), array('$atomic' => 1));
      $lErros++;
    }
  }
//}

echo "\r\n\r\n".$lErros." could not be migrate\r\n\r\n";
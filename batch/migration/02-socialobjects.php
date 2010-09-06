<?php

require_once(dirname(__FILE__).'/../../config/ProjectConfiguration.class.php');

$configuration = ProjectConfiguration::getApplicationConfiguration('platform', 'prod', true);

sfContext::createInstance($configuration);

$logger = sfContext::getInstance()->getLogger();

// Initialize database manager.
$dbManager = new sfDatabaseManager($configuration);
$dbManager->loadConfiguration();


$lObjects = SocialObjectTable::retrieveAll();


foreach ($lObjects as $lObject) {

  $lObject->updateObjectMasterData($lObject->getTitle(), $lObject->getDescription());

  echo $lObject->getUrl()."\r\n";

}
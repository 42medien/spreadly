<?php

require_once(dirname(__FILE__).'/../../config/ProjectConfiguration.class.php');

$configuration = ProjectConfiguration::getApplicationConfiguration('platform', 'prod', true);

sfContext::createInstance($configuration);

$logger = sfContext::getInstance()->getLogger();

// Initialize database manager.
$dbManager = new sfDatabaseManager($configuration);
$dbManager->loadConfiguration();


$lUiCons = UserIdentityConTable::getVerified();

foreach ($lUiCons as $key => $value) {
  $lOi = OnlineIdentityTable::getInstance()->retrieveByPk($value['online_identity_id']);
  if(!$lOi->getUserId()) {
	  $lOi->setUserId($value['user_id']);
	  $lOi->save();
  }
}
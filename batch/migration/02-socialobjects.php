<?php

require_once(dirname(__FILE__).'/../../config/ProjectConfiguration.class.php');

$configuration = ProjectConfiguration::getApplicationConfiguration('platform', 'prod', true);

sfContext::createInstance($configuration);

$logger = sfContext::getInstance()->getLogger();

// Initialize database manager.
$dbManager = new sfDatabaseManager($configuration);
$dbManager->loadConfiguration();


$lActivities = YiidActivityTable::retrieveAllObjects();


foreach ($lActivities as $lActivity) {
  $lUserId = $lActivity->getUId();
  $pOnlineIdenities = UserIdentityConTable::getOnlineIdentitiesForUser($lUserId);

  foreach ($pOnlineIdenities as $oi) {
    if ($oi->getSocialPulishingEnabled()) {
      $lDings[] = $oi->getId();
    }
  }
  echo $lUserId ."  \r\n";
  print_r($lDings);
  echo " ###### \r\n";
}
<?php

require_once(dirname(__FILE__).'/../../config/ProjectConfiguration.class.php');

$configuration = ProjectConfiguration::getApplicationConfiguration('platform', 'dev', true);

sfContext::createInstance($configuration);

$logger = sfContext::getInstance()->getLogger();

// Initialize database manager.
$dbManager = new sfDatabaseManager($configuration);
$dbManager->loadConfiguration();

// necessary memory&execution time
ini_set("max_execution_time", "180");
ini_set('memory_limit','32M');

$lUserId = $_GET[0];
$logger->debug('XXXXXXXXXXXXXXXXXXXXXXXXXX:' . $lUserId  );

$lUiCons = UserIdentityConTable::getOnlineIdentityIdsForUser($lUserId);

$logger->debug('XXXXXXXXXXXXXXXXXXXXXXXXXX: user '. $lUserId . print_r($lUiCons, true) );

//UserRelationTable::updateOwnedIdentities($lUserId, $lUiCons);

$logger->debug('XXXXXXXXXXXXXXXXXXXXXXXXXX:' . $lUserId  );
foreach ($lUiCons as $lOiId) {

  $lUsersConnected = array();
  $lOiIds = OnlineIdentityConTable::getIdentitysConnectedToOi($lOiId);
  foreach ($lOiIds as $lOi) {
    $lUsersConnected[] = UserIdentityConTable::getUserIdsConnectedToOnlineIdentityId($lOi);
  }

  UserRelationTable::updateContactIdentities($lUserId, $lOiIds, $lUsersConnected);
}


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
foreach ($lIds as $key => $value) {
  echo $value['id']."\r\n";
  $lUserId = $value['id'];
  $lUiCons = UserIdentityConTable::getOnlineIdentityIdsForUser($lUserId);
  echo "owned:";
  print_r($lUiCons);
  echo "\r\n";
  //UserRelationTable::updateOwnedIdentities($lUserId, $lUiCons);
  echo "contacts: \r\n";
  foreach ($lUiCons as $lOiId) {
    print_r(OnlineIdentityConTable::getIdentitysConnectedToOi($lOiId)) ;
  }
  echo "######### \r\n\r\n";
}


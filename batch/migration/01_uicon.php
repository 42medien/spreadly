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
  echo $value['id'];
  $lUserId = $value['id'];
  $lUiCons = UserIdentityConTable::getOnlineIdentityIdsForUser($lUserId);
  print_r($lUiCons);
  //UserRelationTable::updateOwnedIdentities($lUserId, $lUiCons);
  foreach ($lUiCons as $lOiId) {
    print_r(OnlineIdentityConTable::getIdentitysConnectedToOi($lOiId)) ;
  }
  echo "######### \r\n\r\n";
}


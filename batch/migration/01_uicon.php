<?php

require_once(dirname(__FILE__).'/../../config/ProjectConfiguration.class.php');

$configuration = ProjectConfiguration::getApplicationConfiguration('platform', 'prod', false);

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
$lQuery->free();

foreach ($lIds as $key => $value) {

  $lUserId = $value['id'];
  $lUiCons = UserIdentityConTable::getOnlineIdentityIdsForUser($lUserId);

  echo memory_get_usage()/(1024*1024) . " - user ".  $value['id']. "\r\n";
  UserRelationTable::updateOwnedIdentities($lUserId, $lUiCons);

  //

  foreach ($lUiCons as $lOiId) {
    $lUsersConnected = array();
    $lOiIds = OnlineIdentityConTable::getIdentitysConnectedToOi($lOiId);
    foreach ($lOiIds as $lOi) {
      $lOnlineIdentity = OnlineIdentityTable::retrieveWithFree($lOi);
//      var_dump($lOnlineIdentity);
  //    $lUsersConnected[] = UserIdentityConTable::getUserIdsConnectedToOnlineIdentity($lOnlineIdentity);
      $lOnlineIdentity->free();
      $lOnlineIdentity = null;
      unset($lOnlineIdentity);
    }

    //  UserRelationTable::updateContactIdentities($lUserId, $lOiIds, $lUsersConnected);
    $lUsersConnected = array();
    unset($lUsersConnected);
    $lOiIds = array();
    unset($lOiIds);
  }



  unset($lUiCons);
  $lUiCons = null;
  unset($lUserId);
  $lUserId = null;

}


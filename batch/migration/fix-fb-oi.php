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
//$lQuery = Doctrine_Query::create()->from('OnlineIdentity oi')->limit(20000)->where('oi.community_id= ?', 34)->andWhere('oi.identifier NOT LIKE ?', 'http://%');
$lQuery = Doctrine_Query::create()->from('OnlineIdentity oi')->limit(20000)->where('oi.community_id= ?', 34)->andWhere('oi.identifier LIKE ?', 'http://www.facebook.com/http://www.facebook.com/%');

$lIds = $lQuery->execute();
$lQuery->free();

$i=0;
foreach ($lIds as $value) {
  echo $i++;echo "\r\n";
  $lIdentifier = str_replace('http://www.facebook.com/http://www.facebook.com/', 'http://www.facebook.com/', $value->getIdentifier());
  echo $lIdentifier;
  //$value->setIdentifier($lIdentifier);
  //$value->save();
}
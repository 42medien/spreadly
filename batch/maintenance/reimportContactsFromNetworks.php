<?php
require_once(dirname(__FILE__).'/../../config/ProjectConfiguration.class.php');

$configuration = ProjectConfiguration::getApplicationConfiguration('platform', 'batch', false);
sfContext::createInstance($configuration);
$logger = sfContext::getInstance()->getLogger();

// Initialize database manager.
$dbManager = new sfDatabaseManager($configuration);
$dbManager->loadConfiguration();


/**
 *  we need all user id's first
 **/
$lOis = OnlineIdentityTable::getOnlineIdentityIdsForFriendRenewal(10);
$lOis = HydrationUtils::flattenArray($lOis);
AmazonSQSUtils::pushToQuque("ImportContacts", $lOis);
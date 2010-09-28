<?php

require_once(dirname(__FILE__).'/../../config/ProjectConfiguration.class.php');

$configuration = ProjectConfiguration::getApplicationConfiguration('platform', 'prod', true);

sfContext::createInstance($configuration);

$logger = sfContext::getInstance()->getLogger();

// Initialize database manager.
$dbManager = new sfDatabaseManager($configuration);
$dbManager->loadConfiguration();



/****
 *
 *
 * avatar migration
 *
 * email migration
 *
 * ..???
 */
echo "######################################### \r\n";
echo "Start migration: 02_community.php \r\n";
echo "######################################### \r\n";
$lTwitter = CommunityTable::retrieveBySlug('twitter');
$lFacebook = CommunityTable::retrieveBySlug('facebook');
$lTwitter->setSocialPublishingPossible(1);
$lTwitter->save();
$lFacebook->setSocialPublishingPossible(1);
$lFacebook->save();
echo "######################################### \r\n";
echo "End migration: 02_community.php\r\n";
echo "######################################### \r\n";
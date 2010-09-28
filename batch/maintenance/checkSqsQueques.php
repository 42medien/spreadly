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


$service = AmazonSQSUtils::initSqsService();
// $queues = $service->listQueues();


  $dummy = $service->getQueueAttributes('SocialObjectParser-dev');
  var_dump($dummy);
  $dummy = $service->getQueueAttributes('SocialObjectParser-dev-local');
  var_dump($dummy);
    $dummy = $service->getQueueAttributes('SocialObjectParser-dev-local');
  var_dump($dummy);


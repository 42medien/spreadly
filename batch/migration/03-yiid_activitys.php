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

  $lSocialObject = SocialObjectTable::retrieveByUrlHash($lActivity->getUrlHash());
  if (!$lSocialObject) {
    $lSocialObject = SocialObjectTable::retrieveByUrl($lActivity->getUrl());
  }
  if ($lSocialObject) {
    $lActivity->setSoId(new MongoId($lSocialObject->getId()));
    $lActivity->save();
  } else {
    echo $lActivity->getUrl();
  }
}
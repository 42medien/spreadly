<?php

require_once(dirname(__FILE__).'/../../config/ProjectConfiguration.class.php');

$configuration = ProjectConfiguration::getApplicationConfiguration('platform', 'prod', true);

sfContext::createInstance($configuration);

$logger = sfContext::getInstance()->getLogger();

// Initialize database manager.
$dbManager = new sfDatabaseManager($configuration);
$dbManager->loadConfiguration();



echo "######################################### \r\n";
echo "Start migration: 01_oi_originalids.php \r\n";
echo "######################################### \r\n";
/**
 *  we need all user id's first
 **/
$lQuery = Doctrine_Query::create()->from('OnlineIdentity oi');
$lOis = $lQuery->execute();
$lQuery->free();

foreach ($lOis as $lIdentity) {
  preg_match('/id=(\w*)/i', $lIdentity->getAuthIdentifier(), $lHits);
  $lIdentity->setOriginalId($lHits[1]);

  // profile_uri

  if ($lIdentity->getCommunity()->getCommunity() == 'twitter')
  {
    $lIdentity->setProfileUri('http://twitter.com/'.$lIdentity->getIdentifier());
  }
  elseif  ($lIdentity->getCommunity()->getCommunity() == 'facebook')
  {
    $lJsonObject = json_decode(UrlUtils::sendGetRequest("https://graph.facebook.com/".$lIdentity->getOriginalId()));
    $lIdentity->setProfileUri($lJsonObject->link);
    $lIdentity->setName($lJsonObject->name);
  }

  AmazonSQSUtils::pushToQuque('ImportContacts', $lIdentity->getId());
  $lIdentity->save();
}
echo "######################################### \r\n";
echo "End migration: 01_oi_originalids.php \r\n";
echo "######################################### \r\n";
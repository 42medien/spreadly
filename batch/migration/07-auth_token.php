<?php

require_once(dirname(__FILE__).'/../../config/ProjectConfiguration.class.php');

$configuration = ProjectConfiguration::getApplicationConfiguration('platform', 'prod', true);

sfContext::createInstance($configuration);

$logger = sfContext::getInstance()->getLogger();

// Initialize database manager.
$dbManager = new sfDatabaseManager($configuration);
$dbManager->loadConfiguration();


$lAuthTokens = Doctrine_Query::create()
    ->from('AuthToken at')
    ->execute();


echo "######################################### \r\n";
echo "Start migration: 07_auth_token.php \r\n";
echo "######################################### \r\n";
foreach ($lAuthTokens as $lToken) {
  $lToken->setTokenType(AuthTokenTable::TOKEN_TYPE_OAUTH);
  $lToken->setCommunityId($lToken->getOnlineIdentity()->getCommunityId());
  $lToken->save();
  echo ".";
}

echo "######################################### \r\n";
echo "END migration: 07_auth_token.php \r\n";
echo "######################################### \r\n";
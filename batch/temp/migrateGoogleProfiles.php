<?php
require_once(dirname(__FILE__).'/../../config/ProjectConfiguration.class.php');

$configuration = ProjectConfiguration::getApplicationConfiguration('statistics', 'dev', false);
sfContext::createInstance($configuration);

$logger = sfContext::getInstance()->getLogger();

// Initialize database manager.
$dbManager = new sfDatabaseManager($configuration);
$dbManager->loadConfiguration();

$lQuery = Doctrine_Query::create()
            ->from('OnlineIdentity oi')
            ->where('oi.auth_identifier LIKE ?', "%www.google.com/profiles%")
            ->limit(50)
            ->execute();

foreach ($lQuery as $q) {
  $a = $q->getAuthIdentifier();
  $r = preg_replace("~http://www.google.com/profiles/~i", "https://profiles.google.com/", $q->getAuthIdentifier());

  $q->setAuthIdentifier($r);
  $q->save();

  echo $a . "\n";
  echo $r . "\n";
  echo "-----------------------------\n";
}
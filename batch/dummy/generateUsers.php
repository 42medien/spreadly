<?php
require_once(dirname(__FILE__).'/../../config/ProjectConfiguration.class.php');
$configuration = ProjectConfiguration::getApplicationConfiguration('platform', 'prod', true);
sfContext::createInstance($configuration);
$logger = sfContext::getInstance()->getLogger();
// Initialize database manager.
$dbManager = new sfDatabaseManager($configuration);
$dbManager->loadConfiguration();

$lNumberOfUsers = 300;

function getName() {
  // no umlauts
  $lArray = array("hans", "michael", "mueller", "marion", "karina", "marco", "mies", "ripanti", "herbert",
                "gudrun", "joachim", "pfefferle", "mausi");
  $lKey = array_rand($lArray,1);

  return $lArray[$lKey];
}

$lHugo = UserTable::retrieveByUsername("hugo");
$lUserIds = array();

print "start to add users\n\n";

for ($i = 0; $i < $lNumberOfUsers; $i++) {
  $lUser = new User();
  $lUser->setUsername(UserUtils::getUniqueUsername(StringUtils::normalizeUsername(getName())));
  $lUser->setFirstname(getName());
  $lUser->setLastname(getName());
  $lUser->save();

  print "added User: ".$lUser->getFullname()."\n";

  $lUserIds[] = $lUser->getId();
}

$lHugo->updateContacts($lUserIds, array());
?>
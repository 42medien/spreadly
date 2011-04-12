<?php
require_once(dirname(__FILE__).'/../../config/ProjectConfiguration.class.php');

$configuration = ProjectConfiguration::getApplicationConfiguration('statistics', 'dev', false);
sfContext::createInstance($configuration);

$logger = sfContext::getInstance()->getLogger();

// Initialize database manager.
$dbManager = new sfDatabaseManager($configuration);
$dbManager->loadConfiguration();

$dm = MongoManager::getDM();

$yas = $dm->getRepository('Documents\YiidActivity')->findBy(array("so_id" => array('$exists' => false)));

foreach ($yas as $ya) {
  $ya->upsertSocialObject();
  $ya->save();
}
?>
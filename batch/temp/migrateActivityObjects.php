<?php
require_once(dirname(__FILE__).'/../../config/ProjectConfiguration.class.php');

$configuration = ProjectConfiguration::getApplicationConfiguration('statistics', 'dev', false);
sfContext::createInstance($configuration);

$logger = sfContext::getInstance()->getLogger();

$dm = MongoManager::getDM();

$yas = $dm->getRepository('Documents\YiidActivity')->findBy(array("social_object" => array('$exists' => false)))->limit(200);

foreach ($yas as $ya) {
  $ya->setNewChecksum(time());
  $ya->save();
}
?>
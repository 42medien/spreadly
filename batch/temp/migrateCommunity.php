<?php
require_once(dirname(__FILE__).'/../../config/ProjectConfiguration.class.php');

$configuration = ProjectConfiguration::getApplicationConfiguration('statistics', 'dev', false);
sfContext::createInstance($configuration);

$logger = sfContext::getInstance()->getLogger();
$dm = MongoManager::getStatsDM();

$muh = $dm->createQueryBuilder('Documents\DealUrlStats')
          ->where("function() { return this.s.Facebook != undefined || this.s.Twitter != undefined || this.s.Google != undefined || this.s.Linkedin != undefined || this.s.LinkedIn != undefined; }")
          ->getQuery()->execute();

foreach ($muh as $argh) {
  var_dump($argh->getServices());
}
?>
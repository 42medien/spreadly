<?php
require_once(dirname(__FILE__).'/../../config/ProjectConfiguration.class.php');

$configuration = ProjectConfiguration::getApplicationConfiguration('statistics', 'dev', false);
sfContext::createInstance($configuration);

$logger = sfContext::getInstance()->getLogger();
$dm = MongoManager::getDM();

for ($i = 0; $i < 15; $i++) {
  $yas = $dm->getRepository('Documents\YiidActivity')->findBy(array("social_object" => array('$exists' => false)))->limit(10);

  print_r("yiid-activity migration\n============================================================\n\n");

  foreach ($yas as $ya) {
    try {
      @StatsFeeder::feed($ya);

      if (@$so = MongoManager::getDM()->getRepository("Documents\SocialObject")->find($ya->getSoId())) {
        @$ya->setSocialObject($so);
        @$ya->save();
        unset($so);
      }

      print_r("yiid-activity: ".$ya->getId()."\n");
      unset($ya);
    } catch (Exception $e) {
      print_r($e->getMessage());
    }
  }
}
?>
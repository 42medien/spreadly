<?php
require_once(dirname(__FILE__).'/../../config/ProjectConfiguration.class.php');

$configuration = ProjectConfiguration::getApplicationConfiguration('statistics', 'prod', false);
sfContext::createInstance($configuration);

$logger = sfContext::getInstance()->getLogger();
$dm = MongoManager::getDM();

for ($i = 0; $i < 5; $i++) {
  $yas = $dm->getRepository('Documents\YiidActivity')->findBy(array("social_object" => array('$exists' => false)))->limit(10);

  if (!$yas->hasNext()) {
    print_r("PFEFFI_SAYS_ITS_DONE");
    return;
  }

  print_r("\n\n");

  foreach ($yas as $ya) {
    try {
      @StatsFeeder::feed($ya);

      if (@$so = MongoManager::getDM()->getRepository("Documents\SocialObject")->find($ya->getSoId())) {
        @$ya->setSocialObject($so);
        @$ya->save();
        unset($so);
      } else {
        $ya->upsertSocialObject();
        $ya->save();
      }

      print_r("yiid-activity: ".$ya->getId()."\n");
      unset($ya);
    } catch (Exception $e) {
      if (@$so = MongoManager::getDM()->getRepository("Documents\SocialObject")->find($ya->getSoId())) {
        @$ya->setSocialObject($so);
        @$ya->save();
        unset($so);
      }
      print_r($e->getMessage());
    }
  }
}
?>
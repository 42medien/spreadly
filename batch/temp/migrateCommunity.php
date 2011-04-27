<?php
require_once(dirname(__FILE__).'/../../config/ProjectConfiguration.class.php');

$configuration = ProjectConfiguration::getApplicationConfiguration('statistics', 'dev', false);
sfContext::createInstance($configuration);

$logger = sfContext::getInstance()->getLogger();
$dm = MongoManager::getStatsDM();

$repos = array('Documents\AnalyticsActivity', 'Documents\ActivityStats', 'Documents\ActivityUrlStats', 'Documents\DealStats', 'Documents\DealUrlStats', 'Documents\DealSummary', 'Documents\DealUrlSummary', 'Documents\HostSummary', 'Documents\UrlSummary');

foreach ($repos as $repo) {
  $services = array('Facebook', 'Twitter', 'Google', 'LinkedIn', 'Linkedin');
  echo "Fixing Repository: $repo …\n";
  $psid_count = 0;
  foreach ($services as $service) {
    $muh = $dm->createQueryBuilder($repo)
              ->where("function() { return this.s.$service != undefined; }")->limit(10)
              ->getQuery()->execute();

    if(!$muh->hasNext()) {
      $psid_count++;
      break;
    }

    echo "=============================== Query done for: $service\n";
    $i = 0;
    foreach ($muh as $el) {
      $s = $el->getServices();
      foreach ($s[$service] as $key => $value) {
        $low = strtolower($service);
        $s[$low][$key] = (array_key_exists($low, $s) && array_key_exists($key, $s[$low])) ? $s[$low][$key]+$value : $value;
      }
      unset($s[$service]);

      $el->setServices($s);
      $dm->persist($el);
      $dm->flush();
      $i++;

      echo "Element $i done\n";
    }
    echo "Fixed $i entries for service: $service\n";
  }

  if ($psid_count>=count($services)) {
    echo "PFEFFI_SAYS_ITS_DONE";
  }

}

?>

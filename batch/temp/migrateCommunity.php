<?php
require_once(dirname(__FILE__).'/../../config/ProjectConfiguration.class.php');

$configuration = ProjectConfiguration::getApplicationConfiguration('statistics', 'prod', false);
sfContext::createInstance($configuration);

$logger = sfContext::getInstance()->getLogger();
$dm = MongoManager::getStatsDM();

$repos = array('Documents\AnalyticsActivity', 'Documents\ActivityStats', 'Documents\ActivityUrlStats', 'Documents\DealStats', 'Documents\DealUrlStats', 'Documents\DealSummary', 'Documents\DealUrlSummary', 'Documents\HostSummary', 'Documents\UrlSummary');

$repo = $repos[0];

  $services = array('Facebook', 'Twitter', 'Google', 'LinkedIn', 'Linkedin');
  echo "Fixing Repository: $repo …\n";

    $muh = $dm->createQueryBuilder($repo)
              ->where("function() { return this.s.Facebook != undefined || this.s.Twitter != undefined || this.s.Google != undefined || this.s.LinkedIn != undefined || this.s.Linkedin != undefined; }")->limit(100)
              ->getQuery()->execute();

    if (!$muh->hasNext()) {
      echo "PFEFFI_SAYS_ITS_DONE";
    }

    echo "===============================\n";
    $i = 0;
    foreach ($muh as $el) {
      $s = $el->getServices();

      foreach ($services as $service) {
        if (array_key_exists($service, $s)) {
          foreach ($s[$service] as $key => $value) {
            $low = strtolower($service);
            $s[$low][$key] = (array_key_exists($low, $s) && array_key_exists($key, $s[$low])) ? $s[$low][$key]+$value : $value;
          }
          unset($s[$service]);
        }
      }
      $el->setServices($s);
      $dm->persist($el);
      $dm->flush();
      $i++;

      echo "Element $i done\n";
    }
?>

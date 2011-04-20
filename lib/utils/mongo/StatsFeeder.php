<?php
use Documents\YiidActivity,
    Documents\SocialObject,
    Documents\AnalyticsActivity,
    Documents\ActivityStats,
    Documents\ActivityUrlStats,
    Documents\DealStats,
    Documents\DealUrlStats,
    Documents\HostSummary,
    Documents\UrlSummary;

/**
 * track stats
 *
 * @author Matthias Pfefferle
 * @author Hannes Schippmann
 */
class StatsFeeder {

  /**
   * Track all the statistics
   *
   * @author Matthias Pfefferle
   * @author Hannes Schippmann
   * @param YiidActivty $pYiidActivtiy
   */
  public static function feed($pYiidActivity) {
    $activity = self::createAnalyticsActivity($pYiidActivity);

    if($activity) {
      self::feedActivityStats($activity);
      self::feedActivityUrlStats($activity);
      self::feedDealStats($activity);
      self::feedDealUrlStats($activity);
      self::feedHostSummary($activity);
      self::feedUrlSummary($activity);
      self::feedDealSummary($activity);
      self::feedDealUrlSummary($activity);
    }
  }

  /**
   * Save Analytics Activity Data
   *
   * @param YiidActivity $pYiidActivity
   * @author Matthias Pfefferle
   * @author Hannes Schippmann
   */
  public static function createAnalyticsActivity($pYiidActivity) {
    $dm = MongoManager::getStatsDM();
    $url = strtolower($pYiidActivity->getUrl());

    $activity = new AnalyticsActivity();

    // The params
    $lParams = self::fillParams($pYiidActivity);

    // At least one online-identity is required. Return if not present.
    if(empty($lParams['services'])) {
      return false;
    }

    $activity->fromArray($lParams);

    $dm->persist($activity);
    $dm->flush();

    return $activity;
  }

  private static function fillParams($pYiidActivity) {
    $pUser = $pYiidActivity->getUser();
    $url = strtolower($pYiidActivity->getUrl());
    $host = parse_url($url, PHP_URL_HOST);
    $day = new MongoDate(strtotime(date("Y-m-d", $pYiidActivity->getC())));
    $hourOfDay = date("G", $pYiidActivity->getC());
    
    $lParams = array(
      'host' => $host,
      'url'  => $url,
      'title'  => $pYiidActivity->getTitle(),
      'day' => new MongoDate(strtotime(date("Y-m-d", $pYiidActivity->getC()))),
      'date' => new MongoDate($pYiidActivity->getC()),

      'yiid_activity_id' => intval($pYiidActivity->getId()),
      'likes' => 1,
      "media_penetration" => self::calcMediaPenetration($pYiidActivity),
      #'clickbacks' => intval($pYiidActivity->getCb()),

      'demographics' => self::fillDemographics($pYiidActivity),
      'user_id' => intval($pUser->getId()),
      'age' => $pUser->getAge()==false ? "u" : intval($pUser->getAge()),
      'gender' => $pUser->getGender()==false ? 'u' : $pUser->getGender(),
      'relationship' => IdentityHelper::toMongoKey($pUser->getRelationshipState()),

      'services' => self::fillServices($pYiidActivity),
      'likes_by_hour' => array($hourOfDay => 1),
      'hour_of_day' => $hourOfDay
    );

    // add shares
    if(!empty($lParams['services'])) {
      $lParams['shares'] = count($lParams['services']);
    }
    
    // add clickbacks
    if ($pYiidActivity->isClickback()) {
      $lParams['clickback_likes'] =  1;
      $lParams['clickback_like_yiid_activity_id'] = $pYiidActivity->getCbReferer();
    }

    // add tags
    if($pYiidActivity->getTags()) {
      foreach($pYiidActivity->getTags() as $tag) {
        $lParams['tags'][$tag] = array(
          "l" => 1,
          "mp" => self::calcMediaPenetration($pYiidActivity),
          "cb" => 0);
        if ($pYiidActivity->isClickback()) {
          $lParams['tags'][$tag]["cbl"] = 1;
        }
      }
    }

    // add deal id
    if ($lDealId = $pYiidActivity->getDId()) {
      $lParams['deal_id'] = $lDealId;
    }

    return $lParams;
  }

  private static function calcMediaPenetration($pYiidActivity) {
    $count = 0;
    foreach($pYiidActivity->getOiids() as $lId) {
      $lOi = OnlineIdentityTable::getInstance()->retrieveByPk($lId);

      if($lOi && $lOi->getFriendCount()==true) {
        $count += intval($lOi->getFriendCount());
      }
    }
    return $count;
  }

  private static function fillServices($pYiidActivity) {
    $services = array();

    foreach($pYiidActivity->getOiids() as $lId) {
      $lOi = OnlineIdentityTable::getInstance()->retrieveByPk($lId);

      if($lOi) {
        $service = self::fillService($pYiidActivity, $lOi);
        $services[$lOi->getCommunity()->getName()] = $service;
      }
    }

    return $services;
  }

  private static function fillService($pYiidActivity, $pOi) {
    $service = array('l' => 1, 'mp' => intval($pOi->getFriendCount()), 'cb' => 0);

    if ($pYiidActivity->isClickback()) {
      $service['cbl'] = 1;
    }
    return $service;
  }

  private static function fillDemographics($pYiidActivity) {
    $pUser = $pYiidActivity->getUser();
    $demografics = array();
    $demografics['rel'][IdentityHelper::toMongoKey($pUser->getRelationshipState())] = 1;
    $demografics['sex'][$pUser->getGender()==false ? 'u' : $pUser->getGender()] = 1;
    // set age
    $a = $pUser->getAge();
    if ($a < 18) {
      $demografics['age']["u_18"] = 1;
    } elseif ($a >= 18 && $a <= 24) {
      $demografics['age']["b_18_24"] = 1;
    } elseif ($a >= 25 && $a <= 34) {
      $demografics['age']["b_25_34"] = 1;
    } elseif ($a >= 35 && $a <= 54) {
      $demografics['age']["b_35_54"] = 1;
    } elseif ($a >= 55) {
      $demografics['age']["o_55"] = 1;
    } else {
      $demografics['age']["u"] = 1;
    }
    return $demografics;
  }


  private static function feedActivityStats($pAnalyticsActivity) {
    if(!$pAnalyticsActivity->getDeal_id()) {
      $lQuery = self::createUpsertForDayAndHost($pAnalyticsActivity, 'Documents\ActivityStats');
      $lQuery->getQuery()->execute();
    }
  }

  private static function feedActivityUrlStats($pAnalyticsActivity) {
    if(!$pAnalyticsActivity->getDeal_id()) {
      $lQuery = self::createUpsertForDayAndHost($pAnalyticsActivity, 'Documents\ActivityUrlStats');
      $lQuery->field('url')->equals($pAnalyticsActivity->getUrl());
      $lQuery->getQuery()->execute();
    }
  }

  private static function feedDealStats($pAnalyticsActivity) {
    if($pAnalyticsActivity->getDeal_id()) {
      $lQuery = self::createUpsertForDayAndHost($pAnalyticsActivity, 'Documents\DealStats');
      $lQuery->field('d_id')->equals($pAnalyticsActivity->getDeal_id());
      $lQuery->getQuery()->execute();
    }
  }

  private static function feedDealUrlStats($pAnalyticsActivity) {
    if($pAnalyticsActivity->getDeal_id()) {
      $lQuery = self::createUpsertForDayAndHost($pAnalyticsActivity, 'Documents\DealUrlStats');
      $lQuery->field('url')->equals($pAnalyticsActivity->getUrl())
             ->field('d_id')->equals($pAnalyticsActivity->getDeal_id());
      $lQuery->getQuery()->execute();
    }
  }

  private static function feedHostSummary($pAnalyticsActivity) {
    if(!$pAnalyticsActivity->getDeal_id()) {
      $lQuery = self::createUpsertForHost($pAnalyticsActivity, 'Documents\HostSummary');
      self::addSummaryIncToQuery($lQuery, $pAnalyticsActivity);
      self::addDemographicsIncToQuery($lQuery, $pAnalyticsActivity);
      self::addServicesIncToQuery($lQuery, $pAnalyticsActivity);
      $lQuery->getQuery()->execute();
    }
  }

  private static function feedUrlSummary($pAnalyticsActivity) {
    if(!$pAnalyticsActivity->getDeal_id()) {
      $lQuery = self::createUpsertForHost($pAnalyticsActivity, 'Documents\UrlSummary');
      $lQuery->field('url')->equals($pAnalyticsActivity->getUrl());
      self::addSummaryIncToQuery($lQuery, $pAnalyticsActivity);
      self::addDemographicsIncToQuery($lQuery, $pAnalyticsActivity);
      self::addServicesIncToQuery($lQuery, $pAnalyticsActivity);
      $lQuery->getQuery()->execute();
    }
  }

  private static function feedDealSummary($pAnalyticsActivity) {
    if($pAnalyticsActivity->getDeal_id()) {
      $lQuery = self::createUpsertForHost($pAnalyticsActivity, 'Documents\DealSummary');
      $lQuery->field('d_id')->equals($pAnalyticsActivity->getDeal_id());
      self::addSummaryIncToQuery($lQuery, $pAnalyticsActivity);
      self::addDemographicsIncToQuery($lQuery, $pAnalyticsActivity);
      self::addServicesIncToQuery($lQuery, $pAnalyticsActivity);
      $lQuery->getQuery()->execute();
    }
  }

  private static function feedDealUrlSummary($pAnalyticsActivity) {
    if($pAnalyticsActivity->getDeal_id()) {
      $lQuery = self::createUpsertForHost($pAnalyticsActivity, 'Documents\DealUrlSummary');
      $lQuery->field('url')->equals($pAnalyticsActivity->getUrl())
             ->field('d_id')->equals($pAnalyticsActivity->getDeal_id());
      self::addSummaryIncToQuery($lQuery, $pAnalyticsActivity);
      self::addDemographicsIncToQuery($lQuery, $pAnalyticsActivity);
      self::addServicesIncToQuery($lQuery, $pAnalyticsActivity);
      $lQuery->getQuery()->execute();
    }
  }

  private static function createUpsertForDayAndHost($pAnalyticsActivity, $pDocumentString) {
    $dm = MongoManager::getStatsDM();
    $lQuery = self::createUpsertForHost($pAnalyticsActivity, $pDocumentString);
    
    $likesByHour = $pAnalyticsActivity->getLikesByHour();
    $lQuery->field('day')->equals($pAnalyticsActivity->getDay())
           ->field('h.'.$pAnalyticsActivity->getHourOfDay())->inc(intval($likesByHour[$pAnalyticsActivity->getHourOfDay()]))
           ->field('l')->inc(intval($pAnalyticsActivity->getLikes()))
           ->field('sh')->inc(intval($pAnalyticsActivity->getShares()))
           ->field('mp')->inc(intval($pAnalyticsActivity->getMediaPenetration()))
           ->field('cb')->inc(intval($pAnalyticsActivity->getClickbacks()))
           ->field('cbl')->inc(intval($pAnalyticsActivity->getClickbackLikes()));

    self::addServicesIncToQuery($lQuery, $pAnalyticsActivity);
    self::addTagsIncToQuery($lQuery, $pAnalyticsActivity);
    self::addDemographicsIncToQuery($lQuery, $pAnalyticsActivity);
    return $lQuery;
  }

  private static function createUpsertForHost($pAnalyticsActivity, $pDocumentString) {
    $dm = MongoManager::getStatsDM();
    $lQuery = $dm->createQueryBuilder($pDocumentString)
                 ->findAndUpdate()
                 ->upsert()
                 ->field('host')->equals($pAnalyticsActivity->getHost());
    return $lQuery;
  }

  private static function addServicesIncToQuery($pQuery, $pAnalyticsActivity) {
    if($pAnalyticsActivity->getServices()) {
      foreach ($pAnalyticsActivity->getServices() as $service => $data) {
        foreach ($data as $type => $value) {
          $pQuery->field('s.'.$service.'.'.$type)->inc($value);
        }
      }
    }
    return $pQuery;
  }

  private static function addTagsIncToQuery($pQuery, $pAnalyticsActivity) {
    if($pAnalyticsActivity->getTags()) {
      foreach ($pAnalyticsActivity->getTags() as $service => $data) {
        foreach ($data as $type => $value) {
          $pQuery->field('t.'.$service.'.'.$type)->inc($value);
        }
      }
    }
    return $pQuery;
  }

  private static function addDemographicsIncToQuery($pQuery, $pAnalyticsActivity) {
    if($pAnalyticsActivity->getDemographics()) {
      foreach ($pAnalyticsActivity->getDemographics() as $service => $data) {
        foreach ($data as $type => $value) {
          $pQuery->field('d.'.$service.'.'.$type)->inc($value);
        }
      }
    }
    return $pQuery;
  }

  private static function addSummaryIncToQuery($pQuery, $pAnalyticsActivity) {
    $pQuery->field('l')->inc(intval($pAnalyticsActivity->getLikes()));
    $pQuery->field('sh')->inc(intval($pAnalyticsActivity->getShares()));
    $pQuery->field('mp')->inc(intval($pAnalyticsActivity->getMediaPenetration()));
    $pQuery->field('cb')->inc(intval($pAnalyticsActivity->getClickbacks()));
    $pQuery->field('cbl')->inc(intval($pAnalyticsActivity->getClickbackLikes()));
    return $pQuery;
  }
}

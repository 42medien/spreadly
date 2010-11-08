<?php
/**
 * track stats
 *
 * @author Matthias Pfefferle
 */
class StatsFeeder {

  public static function getMongoCollection($pCollection) {
    return MongoDbConnector::getInstance()->getCollection(sfConfig::get('app_mongodb_database_name_stats'), $pCollection);
  }

  /**
   * track full stats
   *
   * @author Matthias Pfefferle
   * @param sfEvent $event
   */
  public static function feed($pYiidActivity, $pUser, $pSocialObject) {
    sfContext::getInstance()->getLogger()->err("{StatsFeeder} " . print_r($pEvent, true));

    // full table
    self::createActivitiesData($pYiidActivity, $pUser);
    self::createChartData($pYiidActivity, $pUser);
    //error_log(print_r($pEvent, true) . "\n", 3, dirname(__FILE__).'/event.log');
  }

  /**
   * save full feed
   *
   * @param YiidActivity $pYiidActivity
   * @param User $pUser
   * @author Matthias Pfefferle
   */
  public static function createActivitiesData($pYiidActivity, $pUser) {
    $lCollection = self::getMongoCollection("analytics.activities");
    $lUrlParts = parse_url($pYiidActivity->getUrl());

    $lOnlineIdentities = array();

    foreach ($pYiidActivity->getOiids() as $lId) {
      $lOi = OnlineIdentityTable::getInstance()->retrieveByPk($lId);
      $lOnlineIdentities[] = array('name' => $lOi->getCommunity()->getCommunity(), 'cnt' => $lOi->getFriendCount());
    }

    // basic options
    $lOptions = array(
      'host' => $lUrlParts['host'],
      'url'  => $pYiidActivity->getUrl(),
      'date' => new MongoDate(strtotime(date("Y-m-d", $pYiidActivity->getC()))),
      'pos' => $pYiidActivity->getScore(),
      'verb' => $pYiidActivity->getVerb(),
      'gender' => $pUser->getGender(),
      'user_id' => $pUser->getId(),
      'ya_id' => $pYiidActivity->getId(),
      'age' => $pUser->getAge(),
      'rel' => $pUser->getRelationshipState(),
      'oi' => $lOnlineIdentities,
    );

    // add clickbacks
    if ($pYiidActivity->isClickback()) {
      $lOptions['cb'] =  array('name' => $pYiidActivity->getCbService(), 'ya_id' => $pYiidActivity->getCbReferer());
    }

    $lCollection->insert($lOptions);
  }

  /**
   * save aggregated stat-informations
   *
   * @param YiidActivity $pYiidActivity
   * @param User $pUser
   * @author Matthias Pfefferle
   */
  public static function createChartData($pYiidActivity, $pUser) {
    $lHost = parse_url($pYiidActivity->getUrl(), PHP_URL_HOST);
    $lCollection = self::getMongoCollection(str_replace('.', '_', $lHost).".analytics.charts");

    $lDoc = array(
              'url' => $pYiidActivity->getUrl(),
              'date' => new MongoDate(strtotime(date("Y-m-d", $pYiidActivity->getC())))
            );

    $lOptions = array();
    // set gender
    switch ($pUser->getGender()) {
      case "m":
        $lOptions["d.sex.m"] = 1;
        break;
      case "f":
        $lOptions["d.sex.f"] = 1;
        break;
      default:
        $lOptions["d.sex.u"] = 1;
        break;
    }

    // set relationship
    switch ($pUser->getRelationshipState()) {
      case IdentityHelper::USER_RELATIONSHIP_STATUS_COMPLICATED:
        $lOptions["d.rel.compl"] = 1;
        break;
      case IdentityHelper::USER_RELATIONSHIP_STATUS_ENGAGED:
        $lOptions["d.rel.eng"] = 1;
        break;
      case IdentityHelper::USER_RELATIONSHIP_STATUS_IN_OPEN_RELATIONSHIP:
        $lOptions["d.rel.ior"] = 1;
        break;
      case IdentityHelper::USER_RELATIONSHIP_STATUS_IN_RELATIONSHIP:
        $lOptions["d.rel.rel"] = 1;
        break;
      case IdentityHelper::USER_RELATIONSHIP_STATUS_MARRIED:
        $lOptions["d.rel.mar"] = 1;
        break;
      case IdentityHelper::USER_RELATIONSHIP_STATUS_SINGLE:
        $lOptions["d.rel.singl"] = 1;
        break;
      case IdentityHelper::USER_RELATIONSHIP_STATUS_WIDOWED:
        $lOptions["d.rel.wid"] = 1;
        break;
      default:
        $lOptions["d.rel.u"] = 1;
        break;
    }

    // set age
    $a = $pUser->getAge();
    if ($a < 18) {
      $lOptions["d.age.u_18"] = 1;
    } elseif ($a >= 18 && $a  <= 24) {
      $lOptions["d.age.b_18-24"] = 1;
    } elseif ($a >= 15 && $a  <= 34) {
      $lOptions["d.age.b_25-34"] = 1;
    } elseif ($a >= 35 && $a  <= 54) {
      $lOptions["d.age.b_35-54"] = 1;
    } elseif ($a >= 55) {
      $lOptions["d.age.o_55"] = 1;
    } else {
      $lOptions["d.age.u"] = 1;
    }

    // add online identities
    foreach ($pYiidActivity->getOiids() as $lId) {
      $lOi = OnlineIdentityTable::getInstance()->retrieveByPk($lId);
      $lOnlineIdentities[] = array('name' => $lOi->getCommunity()->getCommunity(), 'cnt' => $lOi->getFriendCount());

      if ($pYiidActivity->getScore() > 0) {
        $lOptions["s.".$lOi->getCommunity()->getCommunity().".pos"] = 1;
      } else {
        $lOptions["s.".$lOi->getCommunity()->getCommunity().".neg"] = 1;
      }

      $lOptions["s.".$lOi->getCommunity()->getCommunity().".cnt"] = $lOi->getFriendCount();
    }

    $lUpdate = array('$inc' => $lOptions);

    $lCollection->update($lDoc, $lUpdate, array("upsert" => true));
  }
}
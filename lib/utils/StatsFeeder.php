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
  public static function feed($pYiidActivity) {
    // full table
    self::createActivitiesData($pYiidActivity);
    self::createChartData($pYiidActivity);
    self::createGlobalStats($pYiidActivity);
  }

  /**
   * save full feed
   *
   * @param YiidActivity $pYiidActivity
   * @param User $pUser
   * @author Matthias Pfefferle
   */
  public static function createActivitiesData($pYiidActivity) {
    $lCollection = self::getMongoCollection("analytics.activities");
    $lUrlParts = parse_url($pYiidActivity->getUrl());

    $lOnlineIdentities = array();

    foreach ($pYiidActivity->getOiids() as $lId) {
      $lOi = OnlineIdentityTable::getInstance()->retrieveByPk($lId);
      if ($lOi) {
        $lOnlineIdentities[] = array('name' => $lOi->getCommunity()->getCommunity(), 'cnt' => intval($lOi->getFriendCount()));
      }
    }

    // online-identities required
    if (empty($lOnlineIdentities)) {
      return false;
    }

    $pUser = $pYiidActivity->getUser();

    // basic options
    $lOptions = array(
      'host' => $lUrlParts['host'],
      'url'  => $pYiidActivity->getUrl(),
      'title'  => $pYiidActivity->getSocialObject()->getTitle(),
      'date' => new MongoDate(strtotime(date("Y-m-d", $pYiidActivity->getC()))),
      'verb' => $pYiidActivity->getVerb(),
      'gender' => $pUser->getGender(),
      'user_id' => intval($pUser->getId()),
      'ya_id' => $pYiidActivity->getId(),
      'age' => intval($pUser->getAge()),
      'rel' => $pUser->getRelationshipState(),
      'oi' => $lOnlineIdentities,
    );

    if ($pYiidActivity->getScore() > 0) {
      $lOptions["pos"] = true;
    } else {
      $lOptions["pos"] = false;
    }

    // add clickbacks
    if ($pYiidActivity->isClickback()) {
      $lOptions['cb'] =  array('name' => $pYiidActivity->getCbService(), 'ya_id' => $pYiidActivity->getCbReferer());
    }

    // add tags
    if ($lTags = $pYiidActivity->getTags()) {
      $lOptions['tags'] = $lTags;
    }

    // add deal id
    if ($lDealId = $pYiidActivity->getDId()) {
      $lOptions['d_id'] = $lDealId;
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
  public static function createChartData($pYiidActivity) {
    $lHost = parse_url($pYiidActivity->getUrl(), PHP_URL_HOST);
    $lDoc = array(
              'url' => $pYiidActivity->getUrl(),
              'date' => new MongoDate(strtotime(date("Y-m-d", $pYiidActivity->getC())))
            );

    $pUser = $pYiidActivity->getUser();
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
      $lOptions["d.age.b_18_24"] = 1;
    } elseif ($a >= 25 && $a  <= 34) {
      $lOptions["d.age.b_25_34"] = 1;
    } elseif ($a >= 35 && $a  <= 54) {
      $lOptions["d.age.b_35_54"] = 1;
    } elseif ($a >= 55) {
      $lOptions["d.age.o_55"] = 1;
    } else {
      $lOptions["d.age.u"] = 1;
    }

    // set tags
    if ($lTags = $pYiidActivity->getTags()) {
      // add each tag with counts
      foreach ($lTags as $lTag) {
        $lOptions["t.".$lTag.".cnt"] = 1;
        // set score
        if ($pYiidActivity->getScore() > 0) {
          $lOptions["t.".$lTag.".pos"] = 1;
        } else {
          $lOptions["t.".$lTag.".neg"] = 1;
        }

        // clickbacks
        if ($pYiidActivity->isClickback()) {
          $lOptions["s.".$lTag.".cb"] =  1;
        }
      }
    }

    $lUpdate = false;

    // add online identities
    foreach ($pYiidActivity->getOiids() as $lId) {
      $lOi = OnlineIdentityTable::getInstance()->retrieveByPk($lId);
      if ($lOi) {
        $lUpdate = true;
        if ($pYiidActivity->getScore() > 0) {
          $lOptions["s.".$lOi->getCommunity()->getCommunity().".pos"] = 1;
        } else {
          $lOptions["s.".$lOi->getCommunity()->getCommunity().".neg"] = 1;
        }
        $lOptions["s.".$lOi->getCommunity()->getCommunity().".cnt"] = intval($lOi->getFriendCount());

        // clickbacks
        if ($pYiidActivity->isClickback()) {
          $lOptions["s.".$pYiidActivity->getCbService().".cb"] =  1;
        }
      }
    }

    if ($lUpdate) {
      // check if activity is a deal
      if ($lDealId = $pYiidActivity->getDId()) {
        // add deal id
        $lOptions['d_id'] = $lDealId;
        $lChart = 'deals';
      } else {
        $lChart = 'charts';
      }
      // mongo collection
      $lCollection = self::getMongoCollection(str_replace('.', '_', $lHost).".analytics.".$lChart);
      // update analytics
      $lCollection->update($lDoc, array('$inc' => $lOptions), array("upsert" => true));
    }
  }

  /**
   *
   * tracks a count for given $pLikeType
   *
   * @param string $pUrl Full Request URI (http://example.com/page)
   * @param string $pLikeType see TYPE_* Constants in this class
   */
  public static function createGlobalStats($pYiidActivity) {
    $lCollection = self::getMongoCollection("visit");

    // data is stored as a tupel of host && month (host => example.com, month => 2010-10)
    $lQueryArray = array();
    $lQueryArray['host'] = parse_url($pYiidActivity->getUrl(), PHP_URL_HOST);
    $lQueryArray['month'] = date('Y-m');

    if ($pYiidActivity->getScore() > 0) {
      $lType = "likes";
    } else {
      $lType = "dislikes";
    }

    if ($lType) {
      // increases the likes/dislikes count
      $lUpdateArray = array( '$inc' => array('stats.day_'.date('d').'.'.$lType => 1, $lType.'_total' => 1, 'act_total' => 1));
    }

    $lCollection->update($lQueryArray, $lUpdateArray, array('upsert' => true));
  }
}
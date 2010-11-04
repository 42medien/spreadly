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
    //error_log(print_r($pEvent, true) . "\n", 3, dirname(__FILE__).'/event.log');
  }

  public static function createActivitiesData($pYiidActivity, $pUser) {
    $lCollection = self::getMongoCollection("analytics.activities");
    $lUrlParts = parse_url($pYiidActivity->getUrl());

    $lOnlineIdentities = array();

    foreach ($pYiidActivity->getOiids() as $lId) {
      $lOi = OnlineIdentityTable::getInstance()->retrieveByPk($lId);
      $lOnlineIdentities[] = array('name' => $lOi->getCommunity()->getName(), 'cnt' => $lOi->getFriendCount());
    }

    $lCollection->insert(array(
      'host' => $lUrlParts['host'],
      'url'  => $pYiidActivity->getUrl(),
      'date' => new MongoDate($pYiidActivity->getC()),
      'pos' => $pYiidActivity->getScore(),
      'verb' => $pYiidActivity->getVerb(),
      'gender' => $pUser->getGender(),
      'user_id' => $pUser->getId(),
      'ya_id' => $pYiidActivity->getId(),
      //'age' => $pUser->getAge(),
      'rel' => $pUser->getRelationshipState(),
      'oi' => $lOnlineIdentities,
      //'cb' => array(
      //  array('name' => 'facebook', 'ya_id' => '')
      //)
    ));
  }
}
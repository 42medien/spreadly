<?php

class DealTable extends Doctrine_Table
{
  const COUPON_TYPE_SINGLE = 'single';
  const COUPON_TYPE_MULTIPLE = 'multiple';
  const COUPON_QUANTITY_UNLIMITED = 0;

  const STATE_SUBMITTED = 'submitted';
  const STATE_APPROVED = 'approved';
  const STATE_DENIED = 'denied';
  const STATE_TRASHED = 'trashed';
  const STATE_PAUSED = 'paused';

  public static function getInstance()
  {
    return Doctrine_Core::getTable('Deal');
  }

  public static function getOverlappingDeals($pOtherDeal) {
    $lDomainProfile = $pOtherDeal->getDomainProfile();
    $lS = $pOtherDeal->getStartDate();
    $lE = $pOtherDeal->getEndDate();

    $lQuery = Doctrine_Query::create()
                ->from('Deal d')
                ->where(
                  'd.id != ? AND '.
                  'd.domain_profile_id = ? AND '.
                  'd.deal_state != "trashed" AND ('.
                  '(d.start_date > ? AND d.start_date <= ?) OR '.
                  '(d.start_date <= ? AND d.end_date >= ?))',

                  array($pOtherDeal->getId(),
                        $lDomainProfile->getId(),
                        $lS, $lE,
                        $lS, $lS));

    return $lQuery->execute();
  }

  public static function isOverlapping($pOtherDeal) {
    $lDeals = self::getOverlappingDeals($pOtherDeal);
    return count($lDeals)!=0;
  }

  /**
   * returns an active deal-object if available
   *
   * @author Matthias Pfefferle
   * @param string $pUrl
   * @return Deal|false
   */
  public static function getActiveDealByHost($pUrl) {
    $host = parse_url($pUrl, PHP_URL_HOST);
    $col = MongoDbConnector::getInstance()->getCollection(sfConfig::get('app_mongodb_database_name'), "deals");
    $today = new MongoDate(strtotime("today"));
    $cond = array(
      "host" => $host,
      "start_date" => array('$lte' => $today),
      "end_date" => array('$gte' => $today)
    );
    $result = $col->find($cond)->limit(1)->sort(array("start_date" => -1));

    $deal = $result->getNext();

    if ($deal && ($deal["is_unlimited"] == true || $deal['remaining_coupon_quantity'] > 0)) {
      return self::getInstance()->find($deal['id']);
    }

    return false;
  }

  /**
   * returns a deal if there is no deal-activity on the host
   *
   * @author Matthias Pfefferle
   * @param string $pUrl
   * @param int $pUserId
   * @return Deal|boolean
   */
  public static function getActiveDealByHostAndUserId($pUrl, $pUserId) {
    $pUrl = UrlUtils::cleanupHostAndUri($pUrl);

    $lDeal = self::getActiveDealByHost($pUrl);

    if ($lDeal) {
      $lYiidActivity = YiidActivityTable::getByDealIdAndUserId($lDeal->getId(), $pUserId);

      if (!$lYiidActivity) {
        return $lDeal;
      }
    }

    return false;
  }

  /**
   * returns a deal if there is a matching deal-activity or
   * if there is no deal on the whole domain
   *
   * @author Matthias Pfefferle
   * @param string $pUrl
   * @param int $pUserId
   * @return Deal|boolean
   */
  public static function getActiveDealByUrlAndUserId($pUrl, $pUserId) {
    $lDeal = self::getActiveDealByHost($pUrl);

    if ($lDeal) {
      if (YiidActivityTable::getByDealIdAndUserIdAndUrl($lDeal->getId(), $pUserId, $pUrl) ||
          !YiidActivityTable::getByDealIdAndUserId($lDeal->getId(), $pUserId)) {
        return $lDeal;
      }
    }

    return false;
  }
}



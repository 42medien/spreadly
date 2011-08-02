<?php

class DealTable extends Doctrine_Table
{
  // Type
  const TYPE_POOL = 'pool';
  
  // Billing type
  const BILLING_TYPE_INVOICE = 'invoice';

  // Coupon type
  const COUPON_TYPE_CODE = 'code';
  const COUPON_TYPE_URL = 'url';
  const COUPON_TYPE_DOWNLOAD = 'download';

  const STATE_INITIAL = 'initial';
  const STATE_STEP_CAMPAIGN = 'step_campaign';
  const STATE_STEP_MOTIVATION = 'step_motivation';
  const STATE_STEP_SHARE = 'step_share';
  const STATE_STEP_COUPON = 'step_coupon';
  const STATE_STEP_BILLING = 'step_billing';
  const STATE_STEP_VERIFY = 'step_verify';
  const STATE_SUBMITTED = 'submitted';
  const STATE_ACTIVE = 'active';
  const STATE_EXPIRED = 'expired';

  public static function getInstance()
  {
    return Doctrine_Core::getTable('Deal');
  }

  public static function getOverlappingDealsByParams($pDealId, $pDomainProfileId, $pStart, $pEnd) {
    $lQuery = Doctrine_Query::create()
                ->from('Deal d')
                ->where(
                  'd.domain_profile_id = ? AND '.
                  'd.deal_state != "trashed" AND ('.
                  '(d.start_date > ? AND d.start_date <= ?) OR '.
                  '(d.start_date <= ? AND d.end_date >= ?))',

                  array($pDomainProfileId,
                        $pStart."", $pEnd."",
                        $pStart."", $pStart.""));

    if(!empty($pDealId)) {
      $lQuery->andWhere('d.id != ?', array($pDealId));
    }
    return $lQuery->execute();
  }

  public static function getOverlappingDeals($pOtherDeal) {
    return self::getOverlappingDealsByParams($pOtherDeal->getId(),
      $pOtherDeal->getDomainProfile()->getId(),
      $pOtherDeal->getStartDate(),
      $pOtherDeal->getEndDate());
  }

  public static function isOverlapping($pOtherDeal) {
    $lDeals = self::getOverlappingDeals($pOtherDeal);
    return count($lDeals)!=0;
  }

  public static function isOverlappingByParams($pDealId, $pDomainProfileId, $pStart, $pEnd) {
    $lDeals = self::getOverlappingDealsByParams($pDealId, $pDomainProfileId, $pStart, $pEnd);
    return count($lDeals)!=0;
  }

  /**
   * returns a running deal-object if available
   *
   * @author Matthias Pfefferle
   * @param string $pUrl
   * @return Deal|false
   */
  public static function getApprovedAndRunning($pUrl) {
    $host = parse_url($pUrl, PHP_URL_HOST);
    $col = MongoDbConnector::getInstance()->getCollection(sfConfig::get('app_mongodb_database_name'), "deals");
    $today = new MongoDate(time());

    $cond = array(
      "host" => $host,
      "start_date" => array('$lte' => $today),
      "end_date" => array('$gte' => $today)
    );

    $result = $col->find($cond)->limit(1)->sort(array("start_date" => -1));

    if($deal = $result->getNext()) {
      return self::getInstance()->find($deal['id']);
    }

    return false;
  }

  /**
   * returns a running deal-object if available
   *
   * @author Matthias Pfefferle
   * @param string $pUrl
   * @return Deal|false
   */
  public static function getRunningByHost($pUrl, $pTags=null) {
    $host = parse_url($pUrl, PHP_URL_HOST);
    $col = MongoDbConnector::getInstance()->getCollection(sfConfig::get('app_mongodb_database_name'), "deals");
    $today = new MongoDate(time());

    $cond = array(
      "host" => $host,
      "start_date" => array('$lte' => $today),
      "end_date" => array('$gte' => $today)
    );

    // added tags to the conditions
    if ($pTags) {
      // trim tags
      if(!is_array($pTags)) {
        $pTags = explode(",", $pTags);
      }
      $lTags = array();
      foreach ($pTags as $lTag) {
        $lTags[] = trim($lTag);
      }
      $cond['$or'] = array(array('tags' => array('$exists' => false)), array('tags' => array('$in' => $lTags)));
    } else {
      $cond["tags"] = array('$exists' => false);
    }

    $result = $col->find($cond)->limit(1)->sort(array("start_date" => -1));
    $deal = null;

    if($result->hasNext()) {
      $deal = $result->getNext();
    }

    if ($deal) {
      return self::getInstance()->find($deal['id']);
    }

    return false;
  }

  /**
   * returns an active deal (running and quantity > 0)
   *
   * @author Matthias Pfefferle
   * @param string $pUrl
   * @return Deal|null
   */
  public static function getActiveByHost($pUrl, $pTags=null) {
    $lDeal = self::getRunningByHost($pUrl, $pTags);
    if ($lDeal && $lDeal->isActive()) {
      return $lDeal;
    }

    return null;
  }

  /**
   * returns a deal if there is no deal-activity on the host
   *
   * @author Matthias Pfefferle
   * @param string $pUrl
   * @param int $pUserId
   * @return Deal|boolean
   */
  public static function getActiveDealByHostAndUserId($pUrl, $pUserId, $pTags = null) {
    $dm = MongoManager::getDM();

    $pUrl = UrlUtils::cleanupHostAndUri($pUrl);
    $lDeal = self::getActiveByHost($pUrl, $pTags);

    if ($lDeal && !$dm->getRepository("Documents\YiidActivity")->findOneBy(array("d_id" => intval($lDeal->getId()), "u_id" => intval($pUserId)))) {
      return $lDeal;
    }

    return false;
  }

  public static function getActiveDealByHostAndTagsAndUserId($pUrl, $pTags, $pUserId) {
    $dm = MongoManager::getDM();

    $pUrl = UrlUtils::cleanupHostAndUri($pUrl);
    $lDeal = self::getActiveByHost($pUrl, $pTags);

    if ($lDeal && !$dm->getRepository("Documents\YiidActivity")->findOneBy(array("d_id" => intval($lDeal->getId()), "u_id" => intval($pUserId)))) {
      return $lDeal;
    }

    return false;
  }
}

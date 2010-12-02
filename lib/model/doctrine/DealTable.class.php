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
}



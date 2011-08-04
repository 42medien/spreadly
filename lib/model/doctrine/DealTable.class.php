<?php

class DealTable extends Doctrine_Table
{
  // Type
  const TYPE_POOL = 'pool';
  
  // Billing type
  const BILLING_TYPE_LIKE = 'like';
  const BILLING_TYPE_MEDIA_PENETRATION = 'media_penetration';

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
  
  public function getNextFromPool($pUser) {
    $nextDeal = $this->createQuery()
                  ->where('id NOT IN ?', $pUser->getParticipatedDeals())
                  ->where('deal_state = ?', self::STATE_ACTIVE)
                  ->andWhere('target_quantity > actual_quantity')
                  ->orderBy('updated_at ASC, pool_hits ASC, created_at ASC')
                  ->fetchOne();
    
    $nextDeal->setPoolHits($nextDeal->getPoolHits()+1);
    $nextDeal->save();
    
    return $nextDeal;
  }
}

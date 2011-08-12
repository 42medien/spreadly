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
  const STATE_CAMPAIGN_COMPLETED = 'campaign_completed';
  const STATE_SHARE_COMPLETED = 'share_completed';
  const STATE_COUPON_COMPLETED = 'coupon_completed';
  const STATE_BILLING_COMPLETED = 'billing_completed';
  const STATE_TO_VERIFY = 'to_verify';
  const STATE_SUBMITTED = 'submitted';
  const STATE_ACTIVE = 'active';
  const STATE_EXPIRED = 'expired';

  public static function getInstance()
  {
    return Doctrine_Core::getTable('Deal');
  }

  public function getNextFromPool($pUser) {
    $q = $this->createQuery()
                  ->where('deal_state = ?', self::STATE_ACTIVE)
                  ->andWhere('target_quantity > actual_quantity');

    if($pUser->getParticipatedDeals() && count($pUser->getParticipatedDeals())>0) {
                $q->andWhere("id NOT IN (".implode(",", $pUser->getParticipatedDeals()).")");
    }

    if(!$pUser->getEmail()) {
                $q->andWhere('email_required = ?', false);
    }

    $nextDeal = $q->orderBy('updated_at ASC, pool_hits ASC, created_at ASC')->fetchOne();

    if($nextDeal) {
      $nextDeal->setPoolHits($nextDeal->getPoolHits()+1);
      $nextDeal->save();
    }

    return $nextDeal;
  }
}

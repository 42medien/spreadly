<?php

class DealTable extends Doctrine_Table
{
  // Type
  const TYPE_POOL = 'pool';
  const TYPE_PUBLISHER = 'publisher';

  // Billing type
  const BILLING_TYPE_LIKE = 'like';
  const BILLING_TYPE_MEDIA_PENETRATION = 'media_penetration';

  // Coupon type
  const COUPON_TYPE_CODE = 'code';
  const COUPON_TYPE_URL = 'url';
  const COUPON_TYPE_DOWNLOAD = 'download';
  const COUPON_TYPE_UNIQUE_CODE = 'unique_code';

  const STATE_INITIAL = 'initial';
  const STATE_CAMPAIGN_COMPLETED = 'campaign_completed';
  const STATE_SHARE_COMPLETED = 'share_completed';
  const STATE_COUPON_COMPLETED = 'coupon_completed';
  const STATE_BILLING_COMPLETED = 'billing_completed';
  const STATE_TO_VERIFY = 'to_verify';
  const STATE_SUBMITTED = 'submitted';
  const STATE_ACTIVE = 'active';
  const STATE_EXPIRED = 'expired';

  public static function getInstance() {
    return Doctrine_Core::getTable('Deal');
  }

  public function getNextFromPool($pUser, $pDomain = null) {
    $nextDeal = $domainProfile = null;

    if ($pDomain && ($domainProfile = DomainProfileTable::getInstance()->retrieveByUrl($pDomain))) {
      $nextDeal = $this->findNextFromPool($pUser, $domainProfile);
    }

    if(!$nextDeal) {
      $nextDeal = $this->findNextFromPool($pUser);
    }

    if ($nextDeal) {
      $nextDeal->setPoolHits($nextDeal->getPoolHits()+1);
      $nextDeal->save();
    }

    return $nextDeal;
  }

  public function findNextFromPool($pUser, $pDomainProfile = null) {
    $q = $this->createQuery()
              ->where('deal_state = ?', self::STATE_ACTIVE)
              ->andWhere('target_quantity > actual_quantity');

    if ($pUser->getParticipatedDeals() && count($pUser->getParticipatedDeals())>0) {
            $q->andWhere("id NOT IN (".implode(",", $pUser->getParticipatedDeals()).")");
    }

    if (!$pUser->getEmail()) {
             $q->andWhere('email_required = ?', false);
    }

    if ($pDomainProfile) {
      $q->andWhere('type = ? AND domain_profile_id = ?', array('publisher', $pDomainProfile->getId()));
    } else {
      $q->andWhere('type = ?', 'pool');
    }

    return $q->orderBy('updated_at ASC, pool_hits ASC, created_at ASC')->fetchOne();
  }

  public function findSubmitted() {
    $q = $this->createQuery()
              ->where('deal_state = ?', self::STATE_SUBMITTED)
              ->orderBy('created_at DESC');

    return $q->execute();
  }
}

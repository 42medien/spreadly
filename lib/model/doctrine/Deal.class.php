<?php

/**
 * Deal
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    yiid_stats
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class Deal extends BaseDeal {

  public function addCoupons($params) {
    if($this->getState()==DealTable::STATE_APPROVED) {
      return $this->saveMultipleCoupons($params, true);
    } else {
      return false;
    }
  }
  
  public function saveCoupons($params) {
    // TODO: Check for not yet saved coupons
    if($this->getState()==DealTable::STATE_SUBMITTED) {
      return $this->saveMultipleCoupons($params);
    } else {
      return false;
    }
  }
  
  public function getRemainingCouponCount() {
    return $this->getCoupons()->count();
  }
  
  public function isUnlimited() {
    return $this->getCouponType()==DealTable::COUPON_TYPE_SINGLE &&
           $this->getCouponQuantity()==DealTable::COUPON_QUANTITY_UNLIMITED;
  }
  
  private function saveMultipleCoupons($params, $pIsAdding=false) {
    $codes = array();
    if($this->isUnlimited()) {
      $codes[] = $params['single_code'];
    } elseif($this->getCouponType()==DealTable::COUPON_TYPE_SINGLE &&
             $this->getCouponQuantity()>0) {
      for ($i=0; $i < $this->getCouponQuantity(); $i++) { 
        $codes[] = $params['single_code'];
      }
    } elseif($this->getCouponType()==DealTable::COUPON_TYPE_MULTIPLE) {
      // Convert line breaks to commas
      $couponString = preg_replace('/\n/', ',', $params['multiple_codes']);
      // Remove all remaining white space
      $couponString = preg_replace('/\s/', '', $couponString);
      $codes = explode(',', $couponString);
    }
    
    foreach ($codes as $code) {
      if(!empty($code)) {
        $c = new Coupon();
        $c->setCode($code);
        $c->setDeal($this);
        $c->save();        
      }
    }
    
    if(!$this->isUnlimited()) {
      $count = count($codes);
      if($pIsAdding) {
        $count+=$this->getCouponQuantity();
      }
      $this->setCouponQuantity($count);
      $this->save();
    }
    return $this->getCouponQuantity();
  }

}

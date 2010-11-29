<?php


class CouponTable extends Doctrine_Table {    
  
  public static function getInstance() {
    return Doctrine_Core::getTable('Coupon');
  }
  
  public static function saveMultipleCoupons($params, $deal) {
    $codes = array();
    if($deal->getCouponType()==DealTable::COUPON_TYPE_SINGLE &&
       $deal->getCouponQuantity()==DealTable::COUPON_QUANTITY_UNLIMITED) {
      $codes[] = $params['single_code'];
    } elseif($deal->getCouponType()==DealTable::COUPON_TYPE_SINGLE &&
             $deal->getCouponQuantity()>0) {
      for ($i=0; $i < $deal->getCouponQuantity(); $i++) { 
        $codes[] = $params['single_code'];
      }
    } elseif($deal->getCouponType()==DealTable::COUPON_TYPE_MULTIPLE) {
      // Convert line breaks to commas
      $couponString = preg_replace('/\n/', ',', $params['multiple_codes']);
      // Remove all remaining white space
      $couponString = preg_replace('/\s/', '', $couponString);
      $codes = explode(',', $couponString);
    }
    
    foreach ($codes as $code) {
      $c = new Coupon();
      $c->setCode($code);
      $c->setDeal($deal);
      $c->save();
    }
    
    if(!($deal->getCouponType()==DealTable::COUPON_TYPE_SINGLE &&
       $deal->getCouponQuantity()==DealTable::COUPON_QUANTITY_UNLIMITED)) {
      $deal->setCouponQuantity(count($codes));
      $deal->save();
    }
  }
}

<?php


class CouponTable extends Doctrine_Table {    
  
  public static function getInstance() {
    return Doctrine_Core::getTable('Coupon');
  }
}

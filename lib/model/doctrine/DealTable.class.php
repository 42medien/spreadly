<?php


class DealTable extends Doctrine_Table
{
   const COUPON_TYPE_SINGLE = 'single';
   const COUPON_TYPE_MULTIPLE = 'multiple';
   const COUPON_QUANTITY_UNLIMITED = 0;

   
    public static function getInstance()
    {
        return Doctrine_Core::getTable('Deal');
    }
}

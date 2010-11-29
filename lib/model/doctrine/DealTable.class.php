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
}

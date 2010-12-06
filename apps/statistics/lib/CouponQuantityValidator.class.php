<?php

/**
 *
 * @author  hannes
 */
class CouponQuantityValidator extends sfValidatorBase {
  public function configure($options = array(), $messages = array()) {
    $this->addOption('id', 'id');
    $this->addOption('coupon_quantity', 'coupon_quantity');

    $this->setMessage('invalid', 'The new coupon quantity must be higher than the current one.');
  }

  protected function doClean($values) {
    $lDealId = isset($values[$this->getOption('id')]) ? $values[$this->getOption('id')] : '';
    $lCouponQuantity = isset($values[$this->getOption('coupon_quantity')]) ? $values[$this->getOption('coupon_quantity')] : '';
    $lDeal = DealTable::getInstance()->find($lDealId);
    if($lDeal && !$lDeal->isUnlimited() &&
       $lDeal->getCouponType()!=DealTable::COUPON_TYPE_MULTIPLE &&
       $lDeal->getCouponQuantity() > $lCouponQuantity) {
      throw new sfValidatorErrorSchema($this, array($this->getOption('coupon_quantity') => new sfValidatorError($this, 'invalid')));      
    } else {
      return $values;
    }
  }

}

<?php

/**
 *
 * @author  hannes
 */
class CouponTypeValidator extends sfValidatorBase {
  public function configure($options = array(), $messages = array()) {

  	$this->addOption('coupon_type', 'coupon_type');
    $this->addOption('coupon_code', 'coupon_code');
    $this->addOption('coupon_url', 'coupon_url');
    $this->addOption('coupon_redeem_url', 'coupon_redeem_url');

    $this->setMessage('required', 'The new coupon quantity must be higher than the current one.');
  }

  protected function doClean($values) {
  	//var_dump($values);die();
  	$lType = $values['coupon_type'];

  	if($lType == 'code') {
  		$values['coupon_url'] = null;
  	} else {
  		$values['coupon_code'] = null;
  		$values['coupon_redeem_url'] = null;
  	}

  	/*
    $lDealId = isset($values[$this->getOption('id')]) ? $values[$this->getOption('id')] : '';
    $lDeal = DealTable::getInstance()->find($lDealId);
    if($lDeal && !$lDeal->isUnlimited() &&
       $lDeal->getCouponType()!=DealTable::COUPON_TYPE_MULTIPLE) {

      $lCouponQuantity = isset($values[$this->getOption('coupon_quantity')]) ? $values[$this->getOption('coupon_quantity')] : '';
      if($lDeal->getCouponQuantity() > $lCouponQuantity) {
        throw new sfValidatorErrorSchema($this, array($this->getOption('coupon_quantity') => new sfValidatorError($this, 'invalid')));
      }
    }*/
    return $values;
  }

}

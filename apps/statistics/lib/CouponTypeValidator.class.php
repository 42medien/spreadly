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

    $this->setMessage('required', 'Required fields');
  }

  protected function doClean($values) {
  	$lType = $values['coupon_type'];

  	//if coupon type is code, check first if is empty. if, throw error. if not, set fields for coupon type: url/download to null
  	//if coupon type is url/download, check if fields are empty. if not, set fields for coupon type: code to null
  	if($lType == 'code') {
  		if($this->isEmpty($values['coupon_code']) || $this->isEmpty($values['coupon_redeem_url'])){
  			throw new sfValidatorErrorSchema($this, array(
  					$this->getOption('coupon_code') => new sfValidatorError($this, 'required'),
  					$this->getOption('coupon_redeem_url') => new sfValidatorError($this, 'required')
  				));
  		}
  		$values['coupon_url'] = null;
  	} elseif ($lType == 'unique_code') {
  	 	if($this->isEmpty($values['coupon_webhook_url']) || $this->isEmpty($values['coupon_redeem_url'])){
  			throw new sfValidatorErrorSchema($this, array(
  					$this->getOption('coupon_webhook_url') => new sfValidatorError($this, 'required'),
  					$this->getOption('coupon_redeem_url') => new sfValidatorError($this, 'required')
  				));
  		}
  		$values['coupon_code'] = null;
  		$values['coupon_url'] = null;
  	} else {
  		if($this->isEmpty($values['coupon_url'])){
  			throw new sfValidatorErrorSchema($this, array(
  					$this->getOption('coupon_url') => new sfValidatorError($this, 'required'),
  				));
  		}
  		$values['coupon_code'] = null;
  		$values['coupon_redeem_url'] = null;
  	}
    return $values;
  }

}

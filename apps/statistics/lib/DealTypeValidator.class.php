<?php

/**
 *
 * @author  KM
 */
class DealTypeValidator extends sfValidatorBase {
  public function configure($options = array(), $messages = array()) {

  	$this->addOption('type', 'type');
  	$this->addOption('tags', 'tags');
    $this->addOption('domain_profile_id', 'domain_profile_id');
    $this->setMessage('required', 'Please select');
    $this->setMessage('invalid', 'Some problems with the deal type');
  }

  protected function doClean($values) {
  	$lType = $values['type'];

  	//if coupon type is code, check first if is empty. if, throw error. if not, set fields for coupon type: url/download to null
  	//if coupon type is url/download, check if fields are empty. if not, set fields for coupon type: code to null
  	if($lType == 'pool') {
  		$values['domain_profile_id'] = null;
  		$values['tags'] = null;
  	} elseif ($lType == 'publisher'){
  	 	if($this->isEmpty($values['domain_profile_id'])){
  			throw new sfValidatorErrorSchema($this, array(
  					$this->getOption('domain_profile_id') => new sfValidatorError($this, 'required'),
						$this->getOption('type') => new sfValidatorError($this, 'invalid')
  				));
  		}
  		$values['tags'] = null;
  	} else {
  		$values['domain_profile_id'] = null;
  		if(trim($values['tags']) == '' || $values['tags'] == null) {
  			throw new sfValidatorErrorSchema($this, array(
  					$this->getOption('tags') => new sfValidatorError($this, 'required'),
						$this->getOption('type') => new sfValidatorError($this, 'invalid')
  				));

  		}

  	}

    return $values;
  }

}

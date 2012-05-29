<?php

/**
 *
 * @author  karina
 */
class TargetQuantityValidator extends sfValidatorBase {
  public function configure($options = array(), $messages = array()) {

  	$this->addOption('target_quantity', 'target_quantity');
  	$this->addOption('target_quantity_mp', 'target_quantity_mp');
    $this->setMessage('required', 'Bitte auswählen!');
    //$this->setMessage('invalid', 'Some problems with the deal type');
  }

  protected function doClean($values) {
  	$lType = $values['type'];

  	if($this->isEmpty($values['target_quantity']) && $this->isEmpty($values['target_quantity_mp'])) {
  			throw new sfValidatorErrorSchema($this, array(
  					$this->getOption('target_quantity') => new sfValidatorError($this, 'required')
  				));
  	}

    return $values;
  }

}

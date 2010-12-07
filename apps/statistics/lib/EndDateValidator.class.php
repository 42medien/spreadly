<?php

/**
 *
 * @author  hannes
 */
class EndDateValidator extends sfValidatorBase {
  public function configure($options = array(), $messages = array()) {
    $this->addOption('start_date', 'start_date');
    $this->addOption('end_date', 'end_date');

    $this->setMessage('invalid', 'The end date must be in the future and after the start date.');
  }

  protected function doClean($values) {
    $lStartDate = isset($values[$this->getOption('start_date')]) ? $values[$this->getOption('start_date')] : '';
    $lEndDate = isset($values[$this->getOption('end_date')]) ? $values[$this->getOption('end_date')] : '';

    if(strtotime($lEndDate) <= strtotime($lStartDate) || strtotime($lEndDate) <= time()) {
      throw new sfValidatorErrorSchema($this, array($this->getOption('end_date') => new sfValidatorError($this, 'invalid')));
    }

    return $values;
  }

}

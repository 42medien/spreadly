<?php

/**
 *
 * @author  hannes
 */
class OverlappingDealValidator extends sfValidatorBase {
  public function configure($options = array(), $messages = array()) {
    $this->addOption('id', 'id');
    $this->addOption('domain_profile_id', 'domain_profile_id');
    $this->addOption('start_date', 'start_date');
    $this->addOption('end_date', 'end_date');

    $this->setMessage('invalid', 'The deal is overlapping another deal.');
  }

  protected function doClean($values) {
    $lDealId = isset($values[$this->getOption('id')]) ? $values[$this->getOption('id')] : '';
    $lDomainProfileId = isset($values[$this->getOption('domain_profile_id')]) ? $values[$this->getOption('domain_profile_id')] : '';
    $lStartDate = isset($values[$this->getOption('start_date')]) ? $values[$this->getOption('start_date')] : '';
    $lEndDate = isset($values[$this->getOption('end_date')]) ? $values[$this->getOption('end_date')] : '';

    if(DealTable::isOverlappingByParams($lDealId, $lDomainProfileId, $lStartDate, $lEndDate)) {
      throw new sfValidatorErrorSchema($this, array($this->getOption('end_date') => new sfValidatorError($this, 'invalid')));      
    }

    return $values;
  }
}

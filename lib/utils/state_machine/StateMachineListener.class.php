<?php
class StateMachineListener extends Doctrine_Record_Listener
{
  protected $_options;
 
  public function __construct(array $options) {
    $this->_options = $options;
  }
  
  public function preInsert(Doctrine_Event $pEvent) {
    // Set initial state
    $lInvoker = $pEvent->getInvoker();
    $lState = $this->getOption('column');
    if(!$lInvoker->$lState) {
      $lInvoker->$lState = $this->getOption('initial');      
    }
  }
}

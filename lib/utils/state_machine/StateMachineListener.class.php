<?php
class StateMachineListener extends Doctrine_Record_Listener
{
  protected $_options;
 
  public function __construct(array $options) {
    $this->_options = $options;
  }
  
  public function preInsert(Doctrine_Event $event) {
    // Set initial state
    $invoker = $event->getInvoker();
    $state = $this->getOption('column');
    if(sfConfig::get('sf_environment')!='test') {
      $invoker->$state = $this->getOption('initial');      
    }
  }
  
  public function preUpdate(Doctrine_Event $event) {
   // Check if a transition is needed and do it if it is possible, throw exception if not
  }
}

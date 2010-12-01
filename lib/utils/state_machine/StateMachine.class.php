<?php
/**
 * Act as StateMachine Doctrine Behavior
 *
 * @author hannes
 */
class StateMachine extends Doctrine_Template {
  
  public function setTableDefinition() {
    $options = $this->getOptions();
    $this->getTable()->setColumn($this->getOption('column'), 'enum', null, array('default' => $this->getOption('initial'), 'values' => $this->getOption('states')));
    $this->addListener(new StateMachineListener($this->getOptions()));
  }
  
  public function setUp() {
    // Setting default column name, if none was set in yaml schema
    $this->_options['column'] = $this->getOption('column', 'state');
    
    // Transforming all froms in events to arrays, if they are not arrays already
    foreach ($this->getOption('events') as $event => $t) {
      $this->_options['events'][$event]['from'] = is_string($t['from']) ? array($t['from']) : $t['from'];
    }
  }
  
  public function transitionTo($pState) {
    return $this->transitionFor($this->getEventNameForState($pState));
  }
  
  public function canTransitionTo($pState) {
    return $this->canTransitionFor($this->getEventNameForState($pState));
  }  
  
  public function getEventNames() {
    $lEvents = $this->getOption('events');
    $lRes = array();
    foreach ($lEvents as $lEventName => $lEventData) {
      $lRes[] = $lEventName;
    }
    return $lRes;
  }
  
  private function getEventNameForState($pState) {
    $lEvents = $this->getOption('events');
    foreach ($lEvents as $lEventName => $lEventData) {
      if(in_array($this->getState(), $lEventData['from']) && $lEventData['to']==$pState) {
        return $lEventName;
      }
    }
    return null;
  }
  
  // Transitions to new state, if it is allowed and fires an event
  public function transitionFor($event) {
    if($this->canTransitionFor($event)) {
      $events = $this->getOption('events');
      $this->setState($events[$event]['to']);
      $this->getInvoker()->save();
      $prefix = $this->getInvoker()->getTable()->getTableName();
      $eventName = $prefix.".event.".$event;
      sfContext::getInstance()->getEventDispatcher()->notify(new sfEvent($this->getInvoker(), $eventName, array("event" => $event)));
      return true;
    }
    throw new sfException("Could not transition for event: ".$event);
  }
  
  public function getState() {
    $state = $this->getOption('column');
    return $this->getInvoker()->$state;
  }

  public function setState($newState) {
    $state = $this->getOption('column');
    $this->getInvoker()->$state = $newState;      
  }
  
  public function canTransitionFor($event) {
    $events = $this->getOption('events');
    if(in_array($this->getState(), $events[$event]['from'])) {
      return true;
    }
    return false;
  }
  
  public function __call($name, $args) {
    $events = $this->getOption('events');
    // All event-names are callable functions and work the same as transitionFor
    // And all event-names get a can<Eventname> function to check if the transition is allowed
    if(array_key_exists($name, $events)) {
      return $this->transitionFor($name);
    } elseif(array_key_exists(strtolower(preg_replace('/^can/', '', $name)), $events)) {
      $name = strtolower(preg_replace('/^can/', '', $name));
      return $this->canTransitionFor($name);
    }

  }
}

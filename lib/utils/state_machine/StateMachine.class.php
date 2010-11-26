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
  
  public function transitionTo($state) {
    if($this->canTransitionTo($state)) {
      $this->getOption('column');
      $this->setState($state);
      $this->save();
      return true;
    }
    throw new sfException("Could not transition to: ".$state);
  }
  
  public function getState() {
    $state = $this->getOption('column');
    return $this->getInvoker()->$state;
  }

  public function setState($newState) {
    $state = $this->getOption('column');
    $this->getInvoker()->$state = $newState;
  }
  
  public function canTransitionTo($state) {
    foreach ($this->getOption('events') as $t) {
      if($t['to']==$state && in_array($this->getState(), $t['from'])) {
        return true;
      }
    }
    return false;
  }
  
  public function __call($name, $args) {
    $events = $this->getOption('events');
    // All events should be callable functions and work the same as transitionTo
    if(array_key_exists($name, $events)) {
      return $this->transitionTo($events[$name]['to']);
    } elseif(array_key_exists(strtolower(preg_replace('/^can/', '', $name)), $events)) {
      $name = strtolower(preg_replace('/^can/', '', $name));
      return $this->canTransitionTo($events[$name]['to']);
    }

  }
}

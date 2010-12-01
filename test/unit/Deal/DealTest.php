<?php

define('SF_ROOT_DIR', realpath(dirname(__FILE__).'/../../..'));

require_once(SF_ROOT_DIR.'/config/ProjectConfiguration.class.php');

new sfDatabaseManager(ProjectConfiguration::getApplicationConfiguration('statistics', 'dev', true));
sfContext::createInstance(ProjectConfiguration::getApplicationConfiguration('statistics', 'dev', true));

class DealTest extends PHPUnit_Framework_TestCase {
  
  public static function setUpBeforeClass() {
    date_default_timezone_set('Europe/Berlin');
  }
  
  public function setUp() {
    sfConfig::set('sf_environment', 'test');
    Doctrine::loadData(dirname(__file__).'/fixtures');
    sfConfig::set('sf_environment', 'dev');

    $this->domainProfile = Doctrine_Query::create()
          ->from('DomainProfile d')
          ->fetchOne();
    $this->user = Doctrine_Query::create()
          ->from('sfGuardUser u')
          ->fetchOne();
    $this->new = new Deal();
    $this->new->setDomainProfile($this->domainProfile);
    $this->new->setSfGuardUser($this->user);
    $this->submitted = Doctrine::getTable('Deal')->findOneBy("state", "submitted");
    $this->approved = Doctrine::getTable('Deal')->findOneBy("state", "approved");
    $this->denied = Doctrine::getTable('Deal')->findOneBy("state", "denied");
    $this->trashed = Doctrine::getTable('Deal')->findOneBy("state", "trashed");
    $this->paused = Doctrine::getTable('Deal')->findOneBy("state", "paused");
    
  }

  public function testInitialStates() {
    $this->assertEquals('submitted', $this->new->getState());
    $this->new->save();
    $this->assertEquals('submitted', $this->new->getState());    
    $this->assertEquals('submitted', $this->submitted->getState());
    $this->assertEquals('approved', $this->approved->getState());
    $this->assertEquals('denied', $this->denied->getState());
    $this->assertEquals('trashed', $this->trashed->getState());
    $this->assertEquals('paused', $this->paused->getState());
  }

  public function testSubmit() {
    $this->assertTrue($this->denied->canSubmit());
    $this->denied->submit();
    $this->assertEquals('submitted', $this->denied->getState());

    $this->assertTrue($this->approved->canSubmit());
    $this->approved->submit();
    $this->assertEquals('submitted', $this->approved->getState());

    $this->assertTrue($this->paused->canSubmit());
    $this->paused->submit();
    $this->assertEquals('submitted', $this->paused->getState());
  }  

  public function testApprove() {
    $this->assertTrue($this->submitted->canApprove());
    $this->submitted->approve();
    $this->assertEquals('approved', $this->submitted->getState());
  }

  public function testApproveWithTransitionTo() {
    $this->assertTrue($this->submitted->canTransitionTo('approved'));
    $this->submitted->transitionTo('approved');
    $this->assertEquals('approved', $this->submitted->getState());
  }

  public function testApproveWithSetState() {
    $this->assertTrue($this->submitted->canApprove());
    $this->submitted->setState('approved');
    $this->submitted->save();
    $this->submitted->refresh();
    $this->assertEquals('approved', $this->submitted->getState());
  }
  
  public function testNotApprovable() {
    $exception = false;
    try {
      $this->assertFalse($this->denied->canApprove());
      $this->denied->approve();
    } catch(sfException $e) {
      $exception = true;
      $this->assertEquals('denied', $this->denied->getState());
      $this->assertEquals('Could not transition for event: approve', $e->getMessage());
    }
    $this->assertTrue($exception);
  }
  
  // TODO: should it throw an exception in this case too???
  /*
  public function testNotApprovableWithSetState() {
    $this->assertFalse($this->denied->canApprove());
    $this->denied->setState('approved');
    $this->denied->save();
    $this->denied->refresh();
    $this->assertEquals('denied', $this->denied->getState());
  }
  */
  
  public function testDeny() {
    $this->assertTrue($this->submitted->canDeny());
    $this->submitted->deny();
    $this->assertEquals('denied', $this->submitted->getState());
  }

  public function testPause() {
    $this->assertTrue($this->approved->canPause());
    $this->approved->pause();
    $this->assertEquals('paused', $this->approved->getState());
  }

  public function testResume() {
    $this->assertTrue($this->paused->canResume());
    $this->paused->resume();
    $this->assertEquals('approved', $this->paused->getState());
  }

  public function testResumeWithTransitionTo() {
    $this->assertTrue($this->paused->canTransitionTo('approved'));
    $this->paused->transitionTo('approved');
    $this->assertEquals('approved', $this->paused->getState());
  }

  public function testTrash() {
    $this->assertTrue($this->submitted->canTrash());
    $this->submitted->trash();
    $this->assertEquals('trashed', $this->submitted->getState());

    $this->assertTrue($this->denied->canTrash());
    $this->denied->trash();
    $this->assertEquals('trashed', $this->denied->getState());

    $this->assertTrue($this->paused->canTrash());
    $this->paused->trash();
    $this->assertEquals('trashed', $this->paused->getState());
  }

  public function testTrashShouldBeLastState() {
    $exception = false;
    try {
      $this->assertFalse($this->trashed->canSubmit());
      $this->trashed->submit();
    } catch(sfException $e) {
      $exception = true;
      $this->assertEquals('trashed', $this->trashed->getState());
      $this->assertEquals('Could not transition for event: submit', $e->getMessage());
    }
    $this->assertTrue($exception);

    $exception = false;
    try {
      $this->assertFalse($this->trashed->canApprove());
      $this->trashed->approve();
    } catch(sfException $e) {
      $exception = true;
      $this->assertEquals('trashed', $this->trashed->getState());
      $this->assertEquals('Could not transition for event: approve', $e->getMessage());
    }
    $this->assertTrue($exception);

    $exception = false;
    try {
      $this->assertFalse($this->trashed->canDeny());
      $this->trashed->deny();
    } catch(sfException $e) {
      $exception = true;
      $this->assertEquals('trashed', $this->trashed->getState());
      $this->assertEquals('Could not transition for event: deny', $e->getMessage());
    }
    $this->assertTrue($exception);

    $exception = false;
    try {
      $this->assertFalse($this->trashed->canPause());
      $this->trashed->pause();
    } catch(sfException $e) {
      $exception = true;
      $this->assertEquals('trashed', $this->trashed->getState());
      $this->assertEquals('Could not transition for event: pause', $e->getMessage());
    }
    $this->assertTrue($exception);

    $exception = false;
    try {
      $this->assertFalse($this->trashed->canResume());
      $this->trashed->resume();
    } catch(sfException $e) {
      $exception = true;
      $this->assertEquals('trashed', $this->trashed->getState());
      $this->assertEquals('Could not transition for event: resume', $e->getMessage());
    }
    $this->assertTrue($exception);
  }
  
  public function testEventApprove() {
    $dispatcher = sfContext::getInstance()->getEventDispatcher();
    $eventName = $this->submitted->getTable()->getTableName().".event.".'approve';
    $dispatcher->connect($eventName,
      array($this, 'eventApproved'));

    $this->assertTrue($dispatcher->hasListeners($eventName));
    $this->eventFired = false;
    $this->submitted->approve();
    $this->assertTrue($this->eventFired);
  }
  
  public function eventApproved($event) {
    $this->eventFired = true;
    $params = $event->getParameters();
    $this->assertEquals("deal.event.approve", $event->getName());
    $this->assertEquals($params['event'], 'approve');
    $this->assertEquals('approved', $event->getSubject()->getState());    
  }
  
  public function testSavedAfterTransition() {
    $this->assertEquals('submitted', $this->submitted->getState());
    $this->submitted->approve();
    $id = $this->submitted->getId();
    $this->submitted = Doctrine::getTable('Deal')->find($id);
    $this->assertEquals('approved', $this->submitted->getState());
  }
  
  
}

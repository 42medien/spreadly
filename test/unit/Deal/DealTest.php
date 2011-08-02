<?php
/*
 * Call like this:
 * phpunit ./test/unit/Deal/DealTest.php
 * phpunit --filter testTruth ./test/unit/Deal/DealTest.php
 */
require_once dirname(__file__).'/../../lib/BaseTestCase.php';

class DealTest extends BaseTestCase {

  public static function setUpBeforeClass() {
    date_default_timezone_set('Europe/Berlin');
  }

  public function setUp() {
    parent::resetMongo();
    sfConfig::set('sf_environment', 'test');
    Doctrine::loadData(dirname(__file__).'/fixtures');
    sfConfig::set('sf_environment', 'dev');
    
    $this->table = Doctrine::getTable('Deal');
    
    $this->deal1 = $this->table->findOneBy('name', 'Campaign No. 1');
    $this->deal2 = $this->table->findOneBy('name', 'Campaign No. 2');
    $this->deal3 = $this->table->findOneBy('name', 'Campaign No. 3');
    
    //$this->col = MongoDbConnector::getInstance()->getCollection(sfConfig::get('app_mongodb_database_name'), "deals");
    
    /*
    $this->domainProfile = Doctrine_Query::create()
          ->from('DomainProfile d')
          ->fetchOne();
    $this->user = Doctrine_Query::create()
          ->from('sfGuardUser u')
          ->fetchOne();
    $this->new = new Deal();
    $this->new->setDomainProfile($this->domainProfile);
    $this->new->setSfGuardUser($this->user);
    $this->submitted = Doctrine::getTable('Deal')->findOneBy("deal_state", "submitted");
    $this->approved = Doctrine::getTable('Deal')->findOneBy("deal_state", "approved");
    $this->denied = Doctrine::getTable('Deal')->findOneBy("deal_state", "denied");
    $this->trashed = Doctrine::getTable('Deal')->findOneBy("deal_state", "trashed");
    $this->paused = Doctrine::getTable('Deal')->findOneBy("deal_state", "paused");

    $this->past = Doctrine::getTable('Deal')->findOneBy("summary", "snirgel_past");
    $this->past->setStartDate(date("c", strtotime("-2 days")));
    $this->past->setEndDate(date("c", strtotime("-1 day")));
    $this->past->save();
    $this->past->saveInitialCoupons(array("single_code" => "xxyyzz"));

    $this->active = Doctrine::getTable('Deal')->findOneBy("summary", "snirgel_active");
    $this->active->setStartDate(date("c", strtotime("-23 hours")));
    $this->active->setEndDate(date("c", strtotime("23 hours")));
    $this->active->save();
    $this->active->saveInitialCoupons(array("single_code" => "aabbcc"));

    $this->future = Doctrine::getTable('Deal')->findOneBy("summary", "snirgel_future");
    $this->future->setStartDate(date("c", strtotime("1 day")));
    $this->future->setEndDate(date("c", strtotime("2 days")));
    $this->future->save();
    $this->future->saveInitialCoupons(array("single_code" => "ddeeff"));
    
    $this->singleUnlimited = Doctrine::getTable('Deal')->findOneBy("summary", "single_unlimited");
    $this->single100 = Doctrine::getTable('Deal')->findOneBy("summary", "single_100");
    $this->multiple = Doctrine::getTable('Deal')->findOneBy("summary", "multiple");
    */
  }
  
    
  public function testInitialDefaults() {
    $this->new = new Deal();
    $this->new->setName("Hansis Spezial");
    $this->new->save();
    
    $this->deal = $this->table->findOneBy("name", "Hansis Spezial");
    
    $this->assertEquals($this->deal->getState(), DealTable::STATE_INITIAL);
    $this->assertEquals($this->deal->getType(), DealTable::TYPE_POOL);
    $this->assertEquals($this->deal->getCouponType(), DealTable::COUPON_TYPE_CODE);
    $this->assertEquals($this->deal->getBillingType(), DealTable::BILLING_TYPE_LIKE);
    
    $this->assertFalse($this->deal->getEmailRequired());
    $this->assertFalse($this->deal->getTosAccepted());

    $this->assertEquals($this->deal->getTargetQuantity(), 0);
    $this->assertEquals($this->deal->getActualQuantity(), 0);
  }
  
  

  public function testStates() {
    $this->new = new Deal();
    $this->new->setName("Hansis Spezial");
    $this->new->save();

    $this->deal = $this->table->findOneBy("name", "Hansis Spezial");
        
    $this->assertTrue($this->deal->canEdit_campaign());
    $this->assertFalse($this->deal->canEdit_share());
    $this->assertFalse($this->deal->canEdit_coupon());
    $this->assertFalse($this->deal->canEdit_billing());
    $this->assertFalse($this->deal->canComplete_edit());
    $this->assertFalse($this->deal->canSubmit());
    $this->assertFalse($this->deal->canApprove());
    $this->assertFalse($this->deal->canExpire());
    
    $this->deal->edit_campaign();
    
    $this->assertTrue($this->deal->canEdit_campaign());
    $this->assertTrue($this->deal->canEdit_share());
    $this->assertFalse($this->deal->canEdit_coupon());
    $this->assertFalse($this->deal->canEdit_billing());
    $this->assertFalse($this->deal->canComplete_edit());
    $this->assertFalse($this->deal->canSubmit());
    $this->assertFalse($this->deal->canApprove());
    $this->assertFalse($this->deal->canExpire());
    
    $this->deal->edit_share();
    
    $this->assertTrue($this->deal->canEdit_campaign());
    $this->assertTrue($this->deal->canEdit_share());
    $this->assertTrue($this->deal->canEdit_coupon());
    $this->assertFalse($this->deal->canEdit_billing());
    $this->assertFalse($this->deal->canComplete_edit());
    $this->assertFalse($this->deal->canSubmit());
    $this->assertFalse($this->deal->canApprove());
    $this->assertFalse($this->deal->canExpire());
    
    $this->deal->edit_coupon();
    
    $this->assertTrue($this->deal->canEdit_campaign());
    $this->assertTrue($this->deal->canEdit_share());
    $this->assertTrue($this->deal->canEdit_coupon());
    $this->assertTrue($this->deal->canEdit_billing());
    $this->assertFalse($this->deal->canComplete_edit());
    $this->assertFalse($this->deal->canSubmit());
    $this->assertFalse($this->deal->canApprove());
    $this->assertFalse($this->deal->canExpire());

    $this->deal->edit_billing();
    
    $this->assertTrue($this->deal->canEdit_campaign());
    $this->assertTrue($this->deal->canEdit_share());
    $this->assertTrue($this->deal->canEdit_coupon());
    $this->assertTrue($this->deal->canEdit_billing());
    $this->assertTrue($this->deal->canComplete_edit());
    $this->assertFalse($this->deal->canSubmit());
    $this->assertFalse($this->deal->canApprove());
    $this->assertFalse($this->deal->canExpire());

    $this->deal->complete_edit();
    
    $this->assertTrue($this->deal->canEdit_campaign());
    $this->assertTrue($this->deal->canEdit_share());
    $this->assertTrue($this->deal->canEdit_coupon());
    $this->assertTrue($this->deal->canEdit_billing());
    $this->assertTrue($this->deal->canComplete_edit());
    $this->assertTrue($this->deal->canSubmit());
    $this->assertFalse($this->deal->canApprove());
    $this->assertFalse($this->deal->canExpire());

    $this->deal->submit();
    
    $this->assertFalse($this->deal->canEdit_campaign());
    $this->assertFalse($this->deal->canEdit_share());
    $this->assertFalse($this->deal->canEdit_coupon());
    $this->assertFalse($this->deal->canEdit_billing());
    $this->assertFalse($this->deal->canComplete_edit());
    $this->assertFalse($this->deal->canSubmit());
    $this->assertTrue($this->deal->canApprove());
    $this->assertFalse($this->deal->canExpire());

    $this->deal->approve();
    
    $this->assertFalse($this->deal->canEdit_campaign());
    $this->assertFalse($this->deal->canEdit_share());
    $this->assertFalse($this->deal->canEdit_coupon());
    $this->assertFalse($this->deal->canEdit_billing());
    $this->assertFalse($this->deal->canComplete_edit());
    $this->assertFalse($this->deal->canSubmit());
    $this->assertFalse($this->deal->canApprove());
    $this->assertTrue($this->deal->canExpire());

    $this->deal->expire();
    
    $this->assertFalse($this->deal->canEdit_campaign());
    $this->assertFalse($this->deal->canEdit_share());
    $this->assertFalse($this->deal->canEdit_coupon());
    $this->assertFalse($this->deal->canEdit_billing());
    $this->assertFalse($this->deal->canComplete_edit());
    $this->assertFalse($this->deal->canSubmit());
    $this->assertFalse($this->deal->canApprove());
    $this->assertFalse($this->deal->canExpire());
  } 
  
  public function testQuantities() {
    $this->deal1->approve();
    $this->deal2->approve();
    $this->deal3->approve();
    
    $this->assertEquals($this->deal1->getTargetQuantity(), 100);
    $this->assertEquals($this->deal1->getActualQuantity(), 98);
    $this->assertEquals($this->deal1->getRemainingQuantity(), 100-98);
    $this->deal1->popCoupon();
    $this->assertEquals($this->deal1->getTargetQuantity(), 100);
    $this->assertEquals($this->deal1->getActualQuantity(), 99);
    $this->assertEquals($this->deal1->getRemainingQuantity(), 100-99);
    $this->deal1->popCoupon();
    $this->assertEquals($this->deal1->getTargetQuantity(), 100);
    $this->assertEquals($this->deal1->getActualQuantity(), 100);
    $this->assertEquals($this->deal1->getRemainingQuantity(), 0);
    $this->assertEquals($this->deal1->getState(), DealTable::STATE_EXPIRED);
    
    $this->assertEquals($this->deal2->getTargetQuantity(), 200);
    $this->assertEquals($this->deal2->getActualQuantity(), 72);
    $this->assertEquals($this->deal2->getRemainingQuantity(), 200-72);
    $this->deal2->popCoupon();
    $this->assertEquals($this->deal2->getTargetQuantity(), 200);
    $this->assertEquals($this->deal2->getActualQuantity(), 73);
    $this->assertEquals($this->deal2->getRemainingQuantity(), 200-73);
    $this->deal2->popCoupon();
    $this->assertEquals($this->deal2->getTargetQuantity(), 200);
    $this->assertEquals($this->deal2->getActualQuantity(), 74);
    $this->assertEquals($this->deal2->getRemainingQuantity(), 200-74);
    $this->assertEquals($this->deal2->getState(), DealTable::STATE_ACTIVE);

    $this->assertEquals($this->deal3->getTargetQuantity(), 500);
    $this->assertEquals($this->deal3->getActualQuantity(), 132);
    $this->assertEquals($this->deal3->getRemainingQuantity(), 500-132);
    $this->deal3->popCoupon();
    $this->assertEquals($this->deal3->getTargetQuantity(), 500);
    $this->assertEquals($this->deal3->getActualQuantity(), 133);
    $this->assertEquals($this->deal3->getRemainingQuantity(), 500-133);
    $this->deal3->popCoupon();
    $this->assertEquals($this->deal3->getTargetQuantity(), 500);
    $this->assertEquals($this->deal3->getActualQuantity(), 134);
    $this->assertEquals($this->deal3->getRemainingQuantity(), 500-134);
    $this->assertEquals($this->deal3->getState(), DealTable::STATE_ACTIVE);
  }
  
    public function testIsActive() {
      $this->assertFalse($this->deal1->isActive());
      $this->assertFalse($this->deal2->isActive());
      $this->assertFalse($this->deal3->isActive());
      
      $this->deal1->approve();
      $this->deal2->approve();
      $this->deal3->approve();

      $this->assertTrue($this->deal1->isActive());
      $this->assertTrue($this->deal2->isActive());
      $this->assertTrue($this->deal3->isActive());
      
      $this->deal1->popCoupon();
      $this->deal1->popCoupon();
      $this->assertFalse($this->deal1->isActive());
    }
  
  
  
  /*
    NOT WORKING CAUSE OF STRANGE EVENT LISTENER IN PHP UNIT TEST PROBLEMS
  
  public function testMongoDealEntriesForApprove() {
    $this->assertFalse($this->col->find(array("id" => intval($this->submitted->getId())))->hasNext());
    sfContext::getInstance()->getEventDispatcher()->connect("deal.event.approve", array('DealListener', 'updateMongoDeal'));
    $this->submitted->approve();
    $this->assertTrue($this->col->find(array("id" => intval($this->submitted->getId())))->hasNext());    
  }

  public function testMongoDealEntriesForResume() {
    $this->assertFalse($this->col->find(array("id" => intval($this->paused->getId())))->hasNext());
    sfContext::getInstance()->getEventDispatcher()->connect("deal.event.resume", array('DealListener', 'updateMongoDeal'));
    $this->paused->resume();
    $this->assertTrue($this->col->find(array("id" => intval($this->paused->getId())))->hasNext());    
  }
  

  public function testMongoDealEntriesDeleted() {
   sfContext::getInstance()->getEventDispatcher()->connect("deal.event.approve", array('DealListener', 'updateMongoDeal'));
    $this->submitted->approve();
    $this->assertTrue($this->col->find(array("id" => intval($this->submitted->getId())))->hasNext());    

    sfContext::getInstance()->getEventDispatcher()->connect("deal.event.submit", array('DealListener', 'updateMongoDeal'));
    $this->submitted->submit();
    $this->assertFalse($this->col->find(array("id" => intval($this->submitted->getId())))->hasNext());    

    sfContext::getInstance()->getEventDispatcher()->connect("deal.event.deny", array('DealListener', 'updateMongoDeal'));
    $this->submitted->deny();
    $this->assertFalse($this->col->find(array("id" => intval($this->submitted->getId())))->hasNext());    

    sfContext::getInstance()->getEventDispatcher()->connect("deal.event.submit", array('DealListener', 'updateMongoDeal'));
    $this->submitted->submit();
  
    sfContext::getInstance()->getEventDispatcher()->connect("deal.event.approve", array('DealListener', 'updateMongoDeal'));
    $this->submitted->approve();
    $this->submitted->refresh();
    $this->assertEquals($this->submitted->getState(), 'approved');
    $this->assertTrue($this->col->find(array("id" => intval($this->submitted->getId())))->hasNext());

    sfContext::getInstance()->getEventDispatcher()->connect("deal.event.pause", array('DealListener', 'updateMongoDeal'));
    $this->submitted->pause();
    $this->assertFalse($this->col->find(array("id" => intval($this->submitted->getId())))->hasNext());    
    
    sfContext::getInstance()->getEventDispatcher()->connect("deal.event.resume", array('DealListener', 'updateMongoDeal'));
    $this->submitted->resume();    
    $this->assertTrue($this->col->find(array("id" => intval($this->submitted->getId())))->hasNext());    
    
    sfContext::getInstance()->getEventDispatcher()->connect("deal.event.pause", array('DealListener', 'updateMongoDeal'));
    $this->submitted->pause();
    sfContext::getInstance()->getEventDispatcher()->connect("deal.event.trash", array('DealListener', 'updateMongoDeal'));
    $this->submitted->trash();    
    $this->assertFalse($this->col->find(array("id" => intval($this->submitted->getId())))->hasNext());
  }
  
  public function testMongoDealEntriesHasCorrectData() {
    sfContext::getInstance()->getEventDispatcher()->connect("deal.event.approve", array('DealListener', 'updateMongoDeal'));
    $this->submitted->approve();
  
    $mongoData = $this->col->find(array("id" => intval($this->submitted->getId())))->getNext();
    $dealData = $this->submitted->toMongoArray();
    
    $this->assertEquals($dealData, $mongoData);
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

  // HS_TODO: should it throw an exception in this case too???
  /*
  public function testNotApprovableWithSetState() {
    $this->assertFalse($this->denied->canApprove());
    $this->denied->setState('approved');
    $this->denied->save();
    $this->denied->refresh();
    $this->assertEquals('denied', $this->denied->getState());
  }


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

  public function testIsActive() {
    $this->assertFalse($this->past->isActive());
    $this->assertTrue($this->active->isActive());
    $this->assertFalse($this->future->isActive());

    $this->active->pause();
    $this->assertFalse($this->active->isActive());

    $this->active->resume();
    $this->assertTrue($this->active->isActive());

    $this->active->setCouponClaimedQuantity($this->active->getCouponQuantity());
    $this->assertFalse($this->active->isActive());
    
    $this->assertFalse($this->singleUnlimited->isActive());
    
    $this->singleUnlimited->setStartDate(date("c", strtotime("-49 hours")));
    $this->singleUnlimited->setEndDate(date("c", strtotime("3 days")));
    $this->singleUnlimited->save();
    
    $this->assertFalse($this->singleUnlimited->isActive());

    $this->singleUnlimited->approve();

    $this->assertTrue($this->singleUnlimited->isActive());
  }

  public function testGetActiveCssClass() {
    $this->assertEquals('deal_inactive', $this->past->getActiveCssClass());
    $this->assertEquals('deal_active', $this->active->getActiveCssClass());
    $this->assertEquals('deal_inactive', $this->future->getActiveCssClass());
  }

  public function testOverlapping() {
    $this->assertFalse(DealTable::isOverlapping($this->past));
    $this->assertFalse(DealTable::isOverlapping($this->active));
    $this->assertFalse(DealTable::isOverlapping($this->future));

    $this->active->setStartDate(date("c", strtotime("-1 day")));
    $this->active->setEndDate(date("c", strtotime("1 day")));
    $this->active->save();

    $this->assertTrue(DealTable::isOverlapping($this->past));
    $this->assertTrue(DealTable::isOverlapping($this->active));
    $this->assertTrue(DealTable::isOverlapping($this->future));

    $this->active->setStartDate(date("c", strtotime("1 day")));
    $this->active->setEndDate(date("c", strtotime("2 days")));
    $this->active->save();

    $this->assertFalse(DealTable::isOverlapping($this->past));
    $this->assertTrue(DealTable::isOverlapping($this->active));
    $this->assertTrue(DealTable::isOverlapping($this->future));

    $this->active->setStartDate(date("c", strtotime("2 days")));
    $this->active->setEndDate(date("c", strtotime("3 days")));
    $this->active->save();

    $this->assertFalse(DealTable::isOverlapping($this->past));
    $this->assertTrue(DealTable::isOverlapping($this->active));
    $this->assertTrue(DealTable::isOverlapping($this->future));

    $this->active->setStartDate(date("c", strtotime("49 hours")));
    $this->active->setEndDate(date("c", strtotime("3 days")));
    $this->active->save();

    $this->assertFalse(DealTable::isOverlapping($this->past));
    $this->assertFalse(DealTable::isOverlapping($this->active));
    $this->assertFalse(DealTable::isOverlapping($this->future));

    $this->active->setStartDate(date("c", strtotime("-3 days")));
    $this->active->setEndDate(date("c", strtotime("-36 hours")));
    $this->active->save();

    $this->assertTrue(DealTable::isOverlapping($this->past));
    $this->assertTrue(DealTable::isOverlapping($this->active));
    $this->assertFalse(DealTable::isOverlapping($this->future));
  }

  public function testOverlappingTrash() {
    $this->past->pause();
    $this->past->trash();
    $this->future->pause();
    $this->future->trash();

    $deals = DealTable::getOverlappingDeals($this->past);

    $this->assertFalse(DealTable::isOverlapping($this->past));
    $this->assertFalse(DealTable::isOverlapping($this->active));
    $this->assertFalse(DealTable::isOverlapping($this->future));
  }


  public function testGetActiveDealByHost() {
    sfContext::getInstance()->getEventDispatcher()->connect("deal.event.pause", array('DealListener', 'updateMongoDeal'));
    $this->active->pause();
    sfContext::getInstance()->getEventDispatcher()->connect("deal.event.resume", array('DealListener', 'updateMongoDeal'));
    $this->active->resume();

    $url = $this->active->getDomainProfile()->getDomain();
    $deal = DealTable::getActiveDealByHost($url);

    $this->assertEquals($this->active->getId(), $deal->getId());
  }
  */
}
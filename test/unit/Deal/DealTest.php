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
    //parent::resetMongo();
    sfConfig::set('sf_environment', 'test');
    Doctrine::loadData(dirname(__file__).'/fixtures');
    sfConfig::set('sf_environment', 'dev');
    
    $this->table = Doctrine::getTable('Deal');

    $this->deal1 = $this->table->findOneBy('name', 'Campaign No. 1');
    $this->deal2 = $this->table->findOneBy('name', 'Campaign No. 2');
    $this->deal3 = $this->table->findOneBy('name', 'Campaign No. 3');
    $this->deal4 = $this->table->findOneBy('name', 'Campaign No. 4');
    $this->deal5 = $this->table->findOneBy('name', 'Campaign No. 5');
    $this->deal6 = $this->table->findOneBy('name', 'Campaign No. 6');

    $this->dealCommission1 = $this->table->findOneBy('name', 'Campaign No. Commission 1');
    $this->dealCommission2 = $this->table->findOneBy('name', 'Campaign No. Commission 2');
    $this->dealCommission3 = $this->table->findOneBy('name', 'Campaign No. Commission 3');
    
    $this->hugo = UserTable::getInstance()->findOneByUsername('hugo');
    $this->affe = UserTable::getInstance()->findOneByUsername('affe');
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

    $this->assertFalse($this->deal->canReset_to_campaign());
    $this->assertFalse($this->deal->canReset_to_share());
    $this->assertFalse($this->deal->canReset_to_coupon());
    $this->assertFalse($this->deal->canReset_to_billing());

    $this->assertTrue($this->deal->canComplete_campaign());
    $this->assertFalse($this->deal->canComplete_share());
    $this->assertFalse($this->deal->canComplete_coupon());
    $this->assertFalse($this->deal->canComplete_billing());
    $this->assertFalse($this->deal->canSubmit());
    $this->assertFalse($this->deal->canApprove());
    $this->assertFalse($this->deal->canExpire());
    
    $this->deal->complete_campaign();
    
    $this->assertTrue($this->deal->canReset_to_campaign());
    $this->assertFalse($this->deal->canReset_to_share());
    $this->assertFalse($this->deal->canReset_to_coupon());
    $this->assertFalse($this->deal->canReset_to_billing());

    $this->assertFalse($this->deal->canComplete_campaign());
    $this->assertTrue($this->deal->canComplete_share());
    $this->assertFalse($this->deal->canComplete_coupon());
    $this->assertFalse($this->deal->canComplete_billing());
    $this->assertFalse($this->deal->canSubmit());
    $this->assertFalse($this->deal->canApprove());
    $this->assertFalse($this->deal->canExpire());
    
    $this->deal->complete_share();

    $this->assertTrue($this->deal->canReset_to_campaign());
    $this->assertTrue($this->deal->canReset_to_share());
    $this->assertFalse($this->deal->canReset_to_coupon());
    $this->assertFalse($this->deal->canReset_to_billing());

    $this->assertFalse($this->deal->canComplete_campaign());
    $this->assertFalse($this->deal->canComplete_share());
    $this->assertTrue($this->deal->canComplete_coupon());
    $this->assertFalse($this->deal->canComplete_billing());
    $this->assertFalse($this->deal->canSubmit());
    $this->assertFalse($this->deal->canApprove());
    $this->assertFalse($this->deal->canExpire());
    
    $this->deal->complete_coupon();

    $this->assertTrue($this->deal->canReset_to_campaign());
    $this->assertTrue($this->deal->canReset_to_share());
    $this->assertTrue($this->deal->canReset_to_coupon());
    $this->assertFalse($this->deal->canReset_to_billing());

    $this->assertFalse($this->deal->canComplete_campaign());
    $this->assertFalse($this->deal->canComplete_share());
    $this->assertFalse($this->deal->canComplete_coupon());
    $this->assertTrue($this->deal->canComplete_billing());
    $this->assertFalse($this->deal->canSubmit());
    $this->assertFalse($this->deal->canApprove());
    $this->assertFalse($this->deal->canExpire());
    
    $this->deal->complete_billing();

    $this->assertTrue($this->deal->canReset_to_campaign());
    $this->assertTrue($this->deal->canReset_to_share());
    $this->assertTrue($this->deal->canReset_to_coupon());
    $this->assertTrue($this->deal->canReset_to_billing());

    $this->assertFalse($this->deal->canComplete_campaign());
    $this->assertFalse($this->deal->canComplete_share());
    $this->assertFalse($this->deal->canComplete_coupon());
    $this->assertFalse($this->deal->canComplete_billing());
    $this->assertTrue($this->deal->canSubmit());
    $this->assertFalse($this->deal->canApprove());
    $this->assertFalse($this->deal->canExpire());
    
    $this->deal->submit();

    $this->assertFalse($this->deal->canReset_to_campaign());
    $this->assertFalse($this->deal->canReset_to_share());
    $this->assertFalse($this->deal->canReset_to_coupon());
    $this->assertFalse($this->deal->canReset_to_billing());

    $this->assertFalse($this->deal->canComplete_campaign());
    $this->assertFalse($this->deal->canComplete_share());
    $this->assertFalse($this->deal->canComplete_coupon());
    $this->assertFalse($this->deal->canComplete_billing());
    $this->assertFalse($this->deal->canSubmit());
    $this->assertTrue($this->deal->canApprove());
    $this->assertFalse($this->deal->canExpire());
    
    $this->deal->approve();
    
    $this->assertFalse($this->deal->canReset_to_campaign());
    $this->assertFalse($this->deal->canReset_to_share());
    $this->assertFalse($this->deal->canReset_to_coupon());
    $this->assertFalse($this->deal->canReset_to_billing());

    $this->assertFalse($this->deal->canComplete_campaign());
    $this->assertFalse($this->deal->canComplete_share());
    $this->assertFalse($this->deal->canComplete_coupon());
    $this->assertFalse($this->deal->canComplete_billing());
    $this->assertFalse($this->deal->canSubmit());
    $this->assertFalse($this->deal->canApprove());
    $this->assertTrue($this->deal->canExpire());
    
    $this->deal->expire();
    
    $this->assertFalse($this->deal->canReset_to_campaign());
    $this->assertFalse($this->deal->canReset_to_share());
    $this->assertFalse($this->deal->canReset_to_coupon());
    $this->assertFalse($this->deal->canReset_to_billing());

    $this->assertFalse($this->deal->canComplete_campaign());
    $this->assertFalse($this->deal->canComplete_share());
    $this->assertFalse($this->deal->canComplete_coupon());
    $this->assertFalse($this->deal->canComplete_billing());
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
    $this->deal1->participate($this->hugo);
    $this->assertEquals($this->deal1->getTargetQuantity(), 100);
    $this->assertEquals($this->deal1->getActualQuantity(), 99);
    $this->assertEquals($this->deal1->getRemainingQuantity(), 100-99);
    $this->deal1->participate($this->affe);
    $this->assertEquals($this->deal1->getTargetQuantity(), 100);
    $this->assertEquals($this->deal1->getActualQuantity(), 100);
    $this->assertEquals($this->deal1->getRemainingQuantity(), 0);
    $this->assertEquals($this->deal1->getState(), DealTable::STATE_EXPIRED);
    
    $this->assertEquals($this->deal2->getTargetQuantity(), 200);
    $this->assertEquals($this->deal2->getActualQuantity(), 72);
    $this->assertEquals($this->deal2->getRemainingQuantity(), 200-72);
    $this->deal2->participate($this->hugo);
    $this->assertEquals($this->deal2->getTargetQuantity(), 200);
    $this->assertEquals($this->deal2->getActualQuantity(), 73);
    $this->assertEquals($this->deal2->getRemainingQuantity(), 200-73);
    $this->deal2->participate($this->affe);
    $this->assertEquals($this->deal2->getTargetQuantity(), 200);
    $this->assertEquals($this->deal2->getActualQuantity(), 74);
    $this->assertEquals($this->deal2->getRemainingQuantity(), 200-74);
    $this->assertEquals($this->deal2->getState(), DealTable::STATE_ACTIVE);

    $this->assertEquals($this->deal3->getTargetQuantity(), 500);
    $this->assertEquals($this->deal3->getActualQuantity(), 132);
    $this->assertEquals($this->deal3->getRemainingQuantity(), 500-132);
    $this->deal3->participate($this->hugo);
    $this->assertEquals($this->deal3->getTargetQuantity(), 500);
    $this->assertEquals($this->deal3->getActualQuantity(), 133);
    $this->assertEquals($this->deal3->getRemainingQuantity(), 500-133);
    $this->deal3->participate($this->affe);
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
    
    $this->deal1->participate($this->hugo);
    $this->deal1->participate($this->affe);
    $this->assertFalse($this->deal1->isActive());
  }
  
  public function testGetNextFromPool() {
    $this->assertEquals($this->table->getNextFromPool($this->hugo)->getId(), $this->deal6->getId());
    $this->assertEquals($this->table->getNextFromPool($this->hugo)->getId(), $this->deal5->getId());
    $this->assertEquals($this->table->getNextFromPool($this->hugo)->getId(), $this->deal4->getId());
    $this->assertEquals($this->table->getNextFromPool($this->hugo)->getId(), $this->deal6->getId());
    $this->assertEquals($this->table->getNextFromPool($this->hugo)->getId(), $this->deal5->getId());
    $this->assertEquals($this->table->getNextFromPool($this->hugo)->getId(), $this->deal4->getId());
    $this->assertEquals($this->table->getNextFromPool($this->hugo)->getId(), $this->deal6->getId());
    $this->assertEquals($this->table->getNextFromPool($this->hugo)->getId(), $this->deal5->getId());
    $this->assertEquals($this->table->getNextFromPool($this->hugo)->getId(), $this->deal4->getId());
    
    $this->deal1->approve();

    $this->assertEquals($this->table->getNextFromPool($this->hugo)->getId(), $this->deal1->getId());
  }
  
  public function testEmailRequired() {
    $this->deal4->expire();
    $this->deal5->expire();
    $this->deal6->expire();
    
    $this->assertTrue($this->table->getNextFromPool($this->hugo)==null);
    $this->assertTrue($this->table->getNextFromPool($this->affe)==null);

    $this->deal1->approve();
    
    $this->assertEquals($this->table->getNextFromPool($this->hugo)->getId(), $this->deal1->getId());
    $this->assertTrue($this->table->getNextFromPool($this->affe)==null);
  }
  
  public function testParticipate() {
    $this->assertTrue($this->hugo->getParticipatedDeals()==null);
    
    $this->deal4->participate($this->hugo);
    $this->assertEquals(1, count($this->hugo->getParticipatedDeals()));
    $this->assertTrue(in_array($this->deal4->getId(), $this->hugo->getParticipatedDeals()));

    $this->deal5->participate($this->hugo);
    $this->assertEquals(2, count($this->hugo->getParticipatedDeals()));
    $this->assertTrue(in_array($this->deal5->getId(), $this->hugo->getParticipatedDeals()));

    $this->deal6->participate($this->hugo);
    $this->assertEquals(3, count($this->hugo->getParticipatedDeals()));
    $this->assertTrue(in_array($this->deal6->getId(), $this->hugo->getParticipatedDeals()));
    
    $exception = false;
    $actual = $this->deal4->getActualQuantity();
    try {
      $this->deal4->participate($this->hugo);
    } catch(sfException $e) {
      $exception = true;
      $this->assertEquals($this->deal4->getActualQuantity(), $actual);
    }
    $this->assertTrue($exception);
  }

  public function testExpire() {
    $this->assertTrue($this->deal4->isActive());
    $this->deal4->participate($this->hugo);
    $this->deal4->participate($this->affe);

    $this->assertFalse($this->deal4->isActive());
    $this->assertEquals(DealTable::STATE_EXPIRED, $this->deal4->getState());
  }
  
  public function testNotApprovable() {
    $exception = false;
    try {
      $this->assertFalse($this->deal4->canApprove());
      $this->deal4->approve();
    } catch(sfException $e) {
      $exception = true;
      $this->assertEquals(DealTable::STATE_ACTIVE, $this->deal4->getState());
      $this->assertEquals('Could not transition for event: approve', $e->getMessage());
    }
    $this->assertTrue($exception);
  }  
  
  public function testLikeCommission() {
    $this->dealCommission1->approve();
    $lActivity = new Documents\YiidActivity();
    $lActivity->setUId($this->hugo->getId());
    $lActivity->setDId($this->dealCommission1->getId());
    $lActivity->setOiids($this->hugo->getOnlineIdentitesAsArray());
    $lActivity->setIUrl('http://notizblog.org/');
    $lActivity->save();
    
    $this->assertEquals(0, $this->dealCommission1->getCommissionPot());
    $com = CommissionTable::getInstance()->findOneByYaId($lActivity->getId());
    $this->assertNotNull($com);
    $this->assertEquals($this->dealCommission1->getId(), $com->getDealId());
    $this->assertEquals($this->dealCommission1->getCommissionPerUnit(), $com->getPrice());
    $this->assertEquals($lActivity->getIId(), $com->getDomainProfileId());
    
  }

  public function testMPCommission() {
    $this->dealCommission2->approve();
    $lActivity = new Documents\YiidActivity();
    $lActivity->setUId($this->hugo->getId());
    $lActivity->setDId($this->dealCommission2->getId());
    $lActivity->setOiids($this->hugo->getOnlineIdentitesAsArray());
    $lActivity->setIUrl('http://notizblog.org/');
    $lActivity->save();
    
    $this->assertEquals(0.0906, $this->dealCommission2->getCommissionPot());
    $com1 = CommissionTable::getInstance()->findOneByYaId($lActivity->getId());
    $this->assertNotNull($com1);
    $this->assertEquals($this->dealCommission2->getId(), $com1->getDealId());
    $this->assertEquals(strval($this->dealCommission2->getCommissionPerUnit()*198), strval($com1->getPrice()));
    $this->assertEquals($lActivity->getIId(), $com1->getDomainProfileId());
    
    $potBefore = $this->dealCommission2->getCommissionPot();
    
    $lActivity = new Documents\YiidActivity();
    $lActivity->setUId($this->affe->getId());
    $lActivity->setDId($this->dealCommission2->getId());
    $lActivity->setOiids($this->affe->getOnlineIdentitesAsArray());
    $lActivity->setIUrl('http://notizblog.org/');
    $lActivity->save();
    
    $this->assertEquals(0, $this->dealCommission2->getCommissionPot());
    $com2 = CommissionTable::getInstance()->findOneByYaId($lActivity->getId());
    $this->assertNotNull($com2);
    $this->assertEquals($this->dealCommission2->getId(), $com2->getDealId());
    $this->assertEquals($potBefore, $com2->getPrice());
    $this->assertEquals($lActivity->getIId(), $com2->getDomainProfileId());
  }

  public function testEmptyPot() {
    $this->dealCommission3->approve();
    $lActivity = new Documents\YiidActivity();
    $lActivity->setUId($this->hugo->getId());
    $lActivity->setDId($this->dealCommission3->getId());
    $lActivity->setOiids($this->hugo->getOnlineIdentitesAsArray());
    $lActivity->setIUrl('http://notizblog.org/');
    $lActivity->save();
    
    $lActivity = new Documents\YiidActivity();
    $lActivity->setUId($this->affe->getId());
    $lActivity->setDId($this->dealCommission3->getId());
    $lActivity->setOiids($this->affe->getOnlineIdentitesAsArray());
    $lActivity->setIUrl('http://notizblog.org/');
    $lActivity->save();
    
    $this->assertEquals(0, $this->dealCommission3->getCommissionPot());
    $com = CommissionTable::getInstance()->findOneByYaId($lActivity->getId());
    $this->assertTrue($com==null);
  }


  
}
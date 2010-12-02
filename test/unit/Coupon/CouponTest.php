<?php

define('SF_ROOT_DIR', realpath(dirname(__FILE__).'/../../..'));

require_once(SF_ROOT_DIR.'/config/ProjectConfiguration.class.php');

new sfDatabaseManager(ProjectConfiguration::getApplicationConfiguration('statistics', 'dev', true));
sfContext::createInstance(ProjectConfiguration::getApplicationConfiguration('statistics', 'dev', true));

class CouponTest extends PHPUnit_Framework_TestCase {
  
  public static function setUpBeforeClass() {
    date_default_timezone_set('Europe/Berlin');
  }
  
  public function setUp() {
    sfConfig::set('sf_environment', 'test');
    Doctrine::loadData(dirname(__file__).'/fixtures');
    sfConfig::set('sf_environment', 'dev');
    
    $this->table = CouponTable::getInstance();
    
    $this->new = new Coupon();
    $this->singleUnlimited = Doctrine::getTable('Deal')->findOneBy("summary", "single_unlimited");
    $this->single100 = Doctrine::getTable('Deal')->findOneBy("summary", "single_100");
    $this->multiple = Doctrine::getTable('Deal')->findOneBy("summary", "multiple");

  }

  public function testSaveSingleUnlimited() {
    $this->singleUnlimited->saveInitialCoupons(array("single_code" => "xxxyyy"));
    $this->assertEquals(1, $this->table->count());
    $this->singleUnlimited->refresh();
    $this->assertEquals(DealTable::COUPON_QUANTITY_UNLIMITED, $this->singleUnlimited->getCouponQuantity());
  }

  public function testSaveSingle100() {
    $this->single100->saveInitialCoupons(array("single_code" => "xxxyyy"));
    $this->assertEquals(1, $this->table->count());
    $this->single100->refresh();
    $this->assertEquals(100, $this->single100->getCouponQuantity());
  }

  public function testSaveMultiple() {
    $this->assertEquals(0, $this->multiple->getCouponQuantity());
    $this->multiple->saveInitialCoupons(array("multiple_codes" => "xxxyyy,yyyxxx,xyxyxy"));
    $this->assertEquals(3, $this->table->count());
    $this->multiple->refresh();
    $this->assertEquals(3, $this->multiple->getCouponQuantity());
  }

  public function testSaveMultipleWithLinebreaksAndWhitespace() {
    $codes = "xxxyyy, yyyxxx
    xyxyxy, abcdef    , ghijkl
    mnopqr";
    $this->multiple->saveInitialCoupons(array("multiple_codes" => $codes));
    $this->assertEquals(6, $this->table->count());
    $this->assertNotNull($this->table->findOneBy('code', 'abcdef'));
    $this->multiple->refresh();
    $this->assertEquals(6, $this->table->count());
    $this->assertEquals(6, $this->multiple->getCouponQuantity());
  }
  
  public function testAddMultipleCoupons() {
    $this->assertEquals(0, $this->multiple->getCouponQuantity());
    $this->assertEquals(0, $this->table->count());
    $this->assertEquals(3, $this->multiple->saveInitialCoupons(array("multiple_codes" => "blah,blubb,hulli")));
    $this->assertEquals(3, $this->multiple->getCouponQuantity());
    $this->assertEquals(3, $this->table->count());
    
    
    $this->multiple->approve();
    
    $this->assertEquals(6, $this->multiple->addMoreCoupons(array("multiple_codes" => "blah,blubb,hulli")));
    $this->multiple->refresh();
    $this->assertEquals(6, $this->table->count());
    
    $this->assertEquals(6, $this->multiple->getCouponQuantity());
    $this->assertEquals(9, $this->multiple->addMoreCoupons(array("multiple_codes" => "har,hur,honk")));
    $this->multiple->refresh();
    
    $this->assertEquals(9, $this->table->count());
    $this->assertEquals(9, $this->multiple->getCouponQuantity());
  }

  public function testAddSingle100Coupons() {
    $this->assertEquals(100, $this->single100->getCouponQuantity());
    $this->assertEquals(0, $this->table->count());

    $this->assertEquals(100, $this->single100->saveInitialCoupons(array("single_code" => "xxyyzz")));
    $this->assertEquals(100, $this->single100->getCouponQuantity());
    $this->assertEquals(1, $this->table->count());
    $this->single100->approve();
    
    $this->assertEquals(103, $this->single100->addMoreCoupons(array("quantity" => 3)));
    $this->assertEquals(103, $this->single100->getCouponQuantity());
    $this->single100->refresh();
    $this->assertEquals(1, $this->table->count());
    $this->assertEquals(103, $this->single100->getCouponQuantity());

    $this->assertEquals(110, $this->single100->addMoreCoupons(array("quantity" => 7)));
    $this->assertEquals(110, $this->single100->getCouponQuantity());
    $this->single100->refresh();
    $this->assertEquals(1, $this->table->count());
    $this->assertEquals(110, $this->single100->getCouponQuantity());
  }

  public function testAddSingleUnlimitedCoupons() {
    $this->assertEquals(0, $this->singleUnlimited->getCouponQuantity());
    $this->assertEquals(0, $this->table->count());
    
    $this->assertEquals(0, $this->singleUnlimited->saveInitialCoupons(array("single_code" => "xxyyzz")));
    $this->assertEquals(0, $this->singleUnlimited->getCouponQuantity());    
    $this->assertEquals(1, $this->table->count());
    $this->singleUnlimited->approve();

    $this->assertEquals(0, $this->singleUnlimited->addMoreCoupons(array("quantity" => 3)));
    $this->assertEquals(0, $this->singleUnlimited->getCouponQuantity());
    $this->singleUnlimited->refresh();
    $this->assertEquals(1, $this->table->count());

    $this->assertEquals(0, $this->singleUnlimited->getCouponQuantity());
  }
  
  public function testInitialRemainingCouponCount() {
    $this->assertEquals(0, $this->singleUnlimited->saveInitialCoupons(array("single_code" => "xxyyzz")));
    $this->assertEquals(100, $this->single100->saveInitialCoupons(array("single_code" => "aabbcc")));
    $this->assertEquals(3, $this->multiple->saveInitialCoupons(array("multiple_codes" => "blahh,blubb,hulli")));
    
    $this->assertEquals('unlimited', $this->singleUnlimited->getRemainingCouponQuantity());
    $this->assertEquals(100, $this->single100->getRemainingCouponQuantity());
    $this->assertEquals(3, $this->multiple->getRemainingCouponQuantity());
  }


  public function testRemainingCouponCount() {
    $this->assertEquals(0, $this->singleUnlimited->saveInitialCoupons(array("single_code" => "xxyyzz")));
    $this->assertEquals(100, $this->single100->saveInitialCoupons(array("single_code" => "aabbcc")));
    $this->assertEquals(3, $this->multiple->saveInitialCoupons(array("multiple_codes" => "blahh,blubb,hulli")));
    
    $this->assertEquals(5, $this->table->count());

    $this->assertEquals("xxyyzz", $this->singleUnlimited->popCoupon());
    $this->assertEquals("aabbcc", $this->single100->popCoupon());
    $this->assertEquals("blahh", $this->multiple->popCoupon());
    
    $this->singleUnlimited->refresh();
    $this->single100->refresh();
    $this->multiple->refresh();
    
    $this->assertEquals('unlimited', $this->singleUnlimited->getRemainingCouponQuantity());
    $this->assertEquals(99, $this->single100->getRemainingCouponQuantity());
    $this->assertEquals(2, $this->multiple->getRemainingCouponQuantity());
    
    $this->assertEquals(4, $this->table->count());
  }

  public function testRemainingCouponCountAfterAddingMore() {
    $this->assertEquals(0, $this->singleUnlimited->saveInitialCoupons(array("single_code" => "xxyyzz")));
    $this->assertEquals(100, $this->single100->saveInitialCoupons(array("single_code" => "aabbcc")));
    $this->assertEquals(3, $this->multiple->saveInitialCoupons(array("multiple_codes" => "blahh,blubb,hulli")));
    
    $this->assertEquals("xxyyzz", $this->singleUnlimited->popCoupon());
    $this->assertEquals(0, $this->singleUnlimited->addMoreCoupons(array("quantity" => 3)));
    $this->assertEquals('unlimited', $this->singleUnlimited->getRemainingCouponQuantity());

    $this->assertEquals("aabbcc", $this->single100->popCoupon());
    $this->assertEquals(103, $this->single100->addMoreCoupons(array("quantity" => 3)));
    $this->assertEquals(102, $this->single100->getRemainingCouponQuantity());

    $this->assertEquals(5, $this->table->count());
    
    $this->assertEquals("blahh", $this->multiple->popCoupon());

    $this->assertEquals(5, $this->multiple->addMoreCoupons(array("multiple_codes" => "harhar,blabla")));
    $this->assertEquals(4, $this->multiple->getRemainingCouponQuantity());

    $this->assertEquals(6, $this->table->count());
    
  }
    
  public function testClaimedCouponCount() {
    $this->singleUnlimited->saveInitialCoupons(array("single_code" => "xxyyzz"));
    $this->single100->saveInitialCoupons(array("single_code" => "aabbcc"));
    $this->multiple->saveInitialCoupons(array("multiple_codes" => "blahh,blubb,hulli"));
    
    $this->assertEquals(0, $this->singleUnlimited->getCouponClaimedQuantity());
    $this->assertEquals(0, $this->single100->getCouponClaimedQuantity());
    $this->assertEquals(0, $this->multiple->getCouponClaimedQuantity());

    $this->singleUnlimited->popCoupon();
    $this->single100->popCoupon();
    $this->multiple->popCoupon();

    $this->assertEquals(1, $this->singleUnlimited->getCouponClaimedQuantity());
    $this->assertEquals(1, $this->single100->getCouponClaimedQuantity());
    $this->assertEquals(1, $this->multiple->getCouponClaimedQuantity());

    $this->singleUnlimited->popCoupon();
    $this->single100->popCoupon();
    $this->multiple->popCoupon();

    $this->singleUnlimited->popCoupon();
    $this->single100->popCoupon();
    $this->multiple->popCoupon();

    $this->assertEquals(3, $this->singleUnlimited->getCouponClaimedQuantity());
    $this->assertEquals(3, $this->single100->getCouponClaimedQuantity());
    $this->assertEquals(3, $this->multiple->getCouponClaimedQuantity());

    $this->single100->addMoreCoupons(array("quantity" => 13));
    $this->multiple->addMoreCoupons(array("multiple_codes" => "harhar,blabla,blubb,blahh,huhihi"));

    $this->assertEquals(3, $this->singleUnlimited->getCouponClaimedQuantity());
    $this->assertEquals(3, $this->single100->getCouponClaimedQuantity());
    $this->assertEquals(3, $this->multiple->getCouponClaimedQuantity());
    
    $this->assertEquals('unlimited', $this->singleUnlimited->getRemainingCouponQuantity());
    $this->assertEquals(110, $this->single100->getRemainingCouponQuantity());
    $this->assertEquals(5, $this->multiple->getRemainingCouponQuantity());

    $this->multiple->popCoupon();
    $this->multiple->popCoupon();
    $this->multiple->popCoupon();
    $this->multiple->popCoupon();
    $this->multiple->popCoupon();

    $this->assertEquals(0, $this->multiple->getRemainingCouponQuantity());

    $this->assertNull($this->multiple->popCoupon());
    
    $this->assertEquals(0, $this->multiple->getRemainingCouponQuantity());
  }

  public function testAddEmptyMultipleCoupons() {
    $this->multiple->saveInitialCoupons(array("multiple_codes" => "blah,blubb,hulli"));
    $this->multiple->approve();
    
    $this->assertEquals(6, $this->multiple->addMoreCoupons(array("multiple_codes" => "blah,blubb,hulli")));
    $this->multiple->refresh();
    $this->assertEquals(6, $this->table->count());    
    $this->assertEquals(6, $this->multiple->getCouponQuantity());

    $this->assertEquals(6, $this->multiple->addMoreCoupons(array("multiple_codes" => "")));
    $this->multiple->refresh();
    $this->assertEquals(6, $this->table->count());
    $this->assertEquals(6, $this->multiple->getCouponQuantity());

    $this->assertEquals(6, $this->multiple->addMoreCoupons(array("multiple_codes" => "   ")));
    $this->multiple->refresh();
    $this->assertEquals(6, $this->table->count());
    $this->assertEquals(6, $this->multiple->getCouponQuantity());

    $this->assertEquals(6, $this->multiple->addMoreCoupons(array("multiple_codes" => "   ,   ,   ")));
    $this->multiple->refresh();
    $this->assertEquals(6, $this->table->count());
    $this->assertEquals(6, $this->multiple->getCouponQuantity());
  }

  
  // Must remain last function to setup test data, since we dont have a test db
  public function testSetup() {
    $this->assertEquals(0, $this->singleUnlimited->saveInitialCoupons(array("single_code" => "xxyyzz")));
    $this->assertEquals(100, $this->single100->saveInitialCoupons(array("single_code" => "aabbcc")));
    $this->assertEquals(3, $this->multiple->saveInitialCoupons(array("multiple_codes" => "blahh,blubb,hulli")));
    $this->singleUnlimited->approve();
    $this->single100->approve();
    $this->multiple->approve();
  }
}

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
    $this->singleUnlimited->saveCoupons(array("single_code" => "xxxyyy"));
    $this->assertEquals(1, $this->table->count());
    $this->singleUnlimited->refresh();
    $this->assertEquals(DealTable::COUPON_QUANTITY_UNLIMITED, $this->singleUnlimited->getCouponQuantity());
  }

  public function testSaveSingle100() {
    $this->single100->saveCoupons(array("single_code" => "xxxyyy"));
    $this->assertEquals(1, $this->table->count());
    $this->single100->refresh();
    $this->assertEquals(100, $this->single100->getCouponQuantity());
  }

  public function testSaveMultiple() {
    $this->assertEquals(0, $this->multiple->getCouponQuantity());
    $this->multiple->saveCoupons(array("multiple_codes" => "xxxyyy,yyyxxx,xyxyxy"));
    $this->assertEquals(3, $this->table->count());
    $this->multiple->refresh();
    $this->assertEquals(3, $this->multiple->getCouponQuantity());
  }

  public function testSaveMultipleWithLinebreaksAndWhitespace() {
    $codes = "xxxyyy, yyyxxx
    xyxyxy, abcdef    , ghijkl
    mnopqr";
    $this->multiple->saveCoupons(array("multiple_codes" => $codes));
    $this->assertEquals(6, $this->table->count());
    $this->assertNotNull($this->table->findOneBy('code', 'abcdef'));
    $this->multiple->refresh();
    $this->assertEquals(6, $this->table->count());
    $this->assertEquals(6, $this->multiple->getCouponQuantity());
  }
  
  public function testAddMultipleCoupons() {
    $this->assertEquals(0, $this->multiple->getCouponQuantity());
    $this->assertEquals(0, $this->table->count());
    $this->assertEquals(3, $this->multiple->saveCoupons(array("multiple_codes" => "blah,blubb,hulli")));
    $this->assertEquals(3, $this->multiple->getCouponQuantity());
    $this->assertEquals(3, $this->table->count());
    
    
    $this->multiple->approve();
    
    $this->assertEquals(6, $this->multiple->addCoupons(array("multiple_codes" => "blah,blubb,hulli")));
    $this->multiple->refresh();
    $this->assertEquals(6, $this->table->count());
    
    $this->assertEquals(6, $this->multiple->getCouponQuantity());
    $this->assertEquals(9, $this->multiple->addCoupons(array("multiple_codes" => "har,hur,honk")));
    $this->multiple->refresh();
    
    $this->assertEquals(9, $this->table->count());
    $this->assertEquals(9, $this->multiple->getCouponQuantity());
  }

  public function testAddSingle100Coupons() {
    $this->assertEquals(100, $this->single100->getCouponQuantity());
    $this->assertEquals(0, $this->table->count());

    $this->assertEquals(100, $this->single100->saveCoupons(array("single_code" => "xxyyzz")));
    $this->assertEquals(100, $this->single100->getCouponQuantity());
    $this->assertEquals(1, $this->table->count());
    $this->single100->approve();
    
    $this->assertEquals(103, $this->single100->addCoupons(array("quantity" => 3)));
    $this->assertEquals(103, $this->single100->getCouponQuantity());
    $this->single100->refresh();
    $this->assertEquals(1, $this->table->count());
    $this->assertEquals(103, $this->single100->getCouponQuantity());

    $this->assertEquals(110, $this->single100->addCoupons(array("quantity" => 7)));
    $this->assertEquals(110, $this->single100->getCouponQuantity());
    $this->single100->refresh();
    $this->assertEquals(1, $this->table->count());
    $this->assertEquals(110, $this->single100->getCouponQuantity());
  }

  public function testAddSingleUnlimitedCoupons() {
    $this->assertEquals(0, $this->singleUnlimited->getCouponQuantity());
    $this->assertEquals(0, $this->table->count());
    
    $this->assertEquals(0, $this->singleUnlimited->saveCoupons(array("single_code" => "xxyyzz")));
    $this->assertEquals(0, $this->singleUnlimited->getCouponQuantity());    
    $this->assertEquals(1, $this->table->count());
    $this->singleUnlimited->approve();

    $this->assertEquals(0, $this->singleUnlimited->addCoupons(array("quantity" => 3)));
    $this->assertEquals(0, $this->singleUnlimited->getCouponQuantity());
    $this->singleUnlimited->refresh();
    $this->assertEquals(1, $this->table->count());

    $this->assertEquals(0, $this->singleUnlimited->getCouponQuantity());
  }
  
  public function testSetup() {
    $this->assertEquals(0, $this->singleUnlimited->saveCoupons(array("single_code" => "xxyyzz")));
    $this->assertEquals(100, $this->single100->saveCoupons(array("single_code" => "aabbcc")));
    $this->assertEquals(3, $this->multiple->saveCoupons(array("multiple_codes" => "blahh,blubb,hulli")));
  }
}

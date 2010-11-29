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
    $this->assertEquals(100, $this->table->count());
    $this->single100->refresh();
    $this->assertEquals(100, $this->single100->getCouponQuantity());
    
  }

  public function testSaveMultiple() {
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
    $this->assertEquals(6, $this->multiple->getCouponQuantity());
  }
  
  public function testAddCoupons() {
    $this->assertFalse($this->multiple->addCoupons(array("multiple_codes" => "blah,blubb,hulli")));
    $this->assertEquals(0, $this->multiple->getCouponQuantity());
    $this->multiple->approve();
    $this->assertEquals(3, $this->multiple->addCoupons(array("multiple_codes" => "blah,blubb,hulli")));
    $this->assertEquals(3, $this->multiple->getCouponQuantity());
  }

}

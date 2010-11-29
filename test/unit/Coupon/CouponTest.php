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
    $this->table->saveMultipleCoupons(array("single_code" => "xxxyyy"), $this->singleUnlimited);
    $this->assertEquals(1, $this->table->count());
  }

  public function testSaveSingle100() {
    $this->table->saveMultipleCoupons(array("single_code" => "xxxyyy"), $this->single100);
    $this->assertEquals(100, $this->table->count());
  }

  public function testSaveMultiple() {
    $this->table->saveMultipleCoupons(array("multiple_codes" => "xxxyyy,yyyxxx,xyxyxy"), $this->multiple);
    $this->assertEquals(3, $this->table->count());
  }

  public function testSaveMultipleWithLinebreaksAndWhitespace() {
    $codes = "xxxyyy, yyyxxx
    xyxyxy, abcdef    , ghijkl
    mnopqr";
    $this->table->saveMultipleCoupons(array("multiple_codes" => $codes), $this->multiple);
    $this->assertEquals(6, $this->table->count());
    $this->assertNotNull($this->table->findOneBy('code', 'abcdef'));
  }

}

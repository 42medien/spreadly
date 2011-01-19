<?php
require_once dirname(__file__).'/../../lib/BaseTestCase.php';

class ChartDataHelperTest extends BaseTestCase {

  public static function setUpBeforeClass() {
    date_default_timezone_set('Europe/Berlin');
  }

  public function setUp() {
    parent::resetMongo();
    sfConfig::set('sf_environment', 'test');
    Doctrine::loadData(dirname(__file__).'/fixtures');
    sfConfig::set('sf_environment', 'dev');
  }
  
  public function testGetActivityData() {
    $from = date('Y-m-d', strtotime("today"));
    $to = date('Y-m-d', strtotime("tomorrow"));
    $data = MongoUtils::getActivityData("www.missmotz.de", $from, $to, 'daily');

    $this->assertEquals(5000, $data['data'][0]['facebook']['likes']);
    $this->assertEquals(0, $data['data'][0]['facebook']['dislikes']);
    $this->assertEquals(1000, $data['data'][0]['twitter']['clickbacks']);
    
    $this->assertEquals(1000, $data['pis'][0]['total']);
    $this->assertEquals(0, $data['pis'][0]['cb']);
    $this->assertEquals(1000, $data['pis'][0]['yiid']);

    $this->assertEquals('www.missmotz.de', $data['filter']['domain']);
    $this->assertEquals($from, $data['filter']['fromDate']);
    $this->assertEquals($to, $data['filter']['toDate']);
    $this->assertEquals('daily', $data['filter']['aggregation']);
  }

  public function testGetAgeData() {
    $from = date('Y-m-d', strtotime("today"));
    $to = date('Y-m-d', strtotime("tomorrow"));
    $data = MongoUtils::getAgeData("www.missmotz.de", $from, $to, 'daily');

    $this->assertEquals(0, $data['data'][0]['u_18']);
    $this->assertEquals(0, $data['data'][0]['b_18_24']);
    $this->assertEquals(0, $data['data'][0]['b_25_34']);
    $this->assertEquals(0, $data['data'][0]['b_35_54']);
    $this->assertEquals(1000, $data['data'][0]['o_55']);

    $this->assertEquals('www.missmotz.de', $data['filter']['domain']);
    $this->assertEquals($from, $data['filter']['fromDate']);
    $this->assertEquals($to, $data['filter']['toDate']);
    $this->assertEquals('daily', $data['filter']['aggregation']);
  }
}

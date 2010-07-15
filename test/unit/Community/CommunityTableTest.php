<?php
require_once dirname(__file__).'/../../lib/BaseTestCase.php';

class  CommunityTableTest extends BaseTestCase {


  public static function setUpBeforeClass() {
    Doctrine::loadData(dirname(__file__).'/fixtures');
  }

  public function testRetrieveByDomain() {
    $result = CommunityTable::retrieveByDomain("google");

    $this->assertTrue(2 <= count($result));
  }
}
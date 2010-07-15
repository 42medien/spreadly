<?php
require_once dirname(__file__).'/../../lib/BaseTestCase.php';

class OnlineIdentityTableTest extends BaseTestCase {

  public static function setUpBeforeClass() {
    Doctrine::loadData(dirname(__file__).'/fixtures');
  }

  public function testGetName() {

  }


  public function testGetOnlineIdentities() {

  }
}
<?php
require_once dirname(__file__).'/../../lib/BaseTestCase.php';

class OnlineIdentityTableTest extends BaseTestCase {

  public static function setUpBeforeClass() {
    Doctrine::loadData('./fixtures');
  }

  public function testGetName() {

  }


  public function testGetOnlineIdentities() {
  }
}
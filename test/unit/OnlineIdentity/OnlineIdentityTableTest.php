<?php
require_once dirname(__file__).'/../../lib/BaseTestCase.php';

class OnlineIdentityTableTest extends BaseTestCase {

  public function setUpBeforeClass() {
    Doctrine::loadData('/fixtures/onlineidentity.yml');
  }

  public function testGetName() {

  }


  public function testGetOnlineIdentities() {
  }
}
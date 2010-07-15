<?php
require_once dirname(__file__).'/../../lib/BaseTestCase.php';

class OnlineIdentityTableTest extends BaseTestCase {

  public static function setUpBeforeClass() {
    Doctrine::loadData(dirname(__file__).'/fixtures');
  }


  public function testGetOnlineIdentities() {
    $lUserHugo = UserTable::getByIdentifier('hugo');
    $lIdentities = $lUserHugo->getOnlineIdentities();
    $lOis =    UserIdentityConTable::getOnlineIdentitiesForUser($lUserHugo->getId());
    $this->assertEquals(2, count($lOis));
    $this->assertTrue(is_array($lOis));
  }
}
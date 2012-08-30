<?php
require_once dirname(__file__).'/../../lib/BaseTestCase.php';

class UserIdentityConTableTest extends BaseTestCase {

  public static function setUpBeforeClass() {
    parent::resetMongo();
    Doctrine::loadData(dirname(__file__).'/fixtures');
  }

  public function testGetOnlineIdentities() {
    $lUserHugo = UserTable::getByIdentifier('hugo');
    $lIdentities =    UserIdentityConTable::getOnlineIdentitiesForUser($lUserHugo->getId());
    $this->assertEquals(2, count($lIdentities));
    $this->assertTrue(is_array($lIdentities));
  }
}
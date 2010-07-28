<?php
require_once dirname(__file__).'/../../lib/BaseTestCase.php';

class UserTest extends BaseTestCase {

  public static function setUpBeforeClass() {
    parent::resetMongo();
    Doctrine::loadData(dirname(__file__).'/fixtures');
  }


  public function testGetOnlineIdentities() {
    $lUserHugo = UserTable::getByIdentifier('hugo');
    $lIdentities = $lUserHugo->getOnlineIdentities();
    $this->assertEquals(2, count($lIdentities));
    $this->assertTrue(is_array($lIdentities));
  }


  public function testUpdateOwnedIdentities() {
    parent::resetMongo();
    Doctrine::loadData(dirname(__file__).'/fixtures');

    $lUserHugo = UserTable::getByIdentifier('hugo');
    $lUserHugo->updateOwnedIdentities(array("1", "2", "34"));

    $lRelation = $lUserHugo->retrieveUserRelations();

    $this->assertTrue(in_array("34", $lRelation->getOwnedOi()));

  }

  public function testAddOnlineIdentity() {
    $lUser = UserTable::retrieveByUsername("hugo");

    $lOnlineIdentity = $lUser->addOnlineIdentity();
  }
}
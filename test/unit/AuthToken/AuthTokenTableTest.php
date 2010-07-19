<?php
require_once dirname(__file__).'/../../lib/BaseTestCase.php';

class AuthTokenTableTest extends BaseTestCase {

  public static function setUpBeforeClass() {
    Doctrine::loadData(dirname(__file__).'/fixtures');
  }


  public function testGetUsersAuthTokens() {
    $lUserHugo = UserTable::getByIdentifier('hugo');
    $lTokens = AuthTokenTable::getTokensForUserQuery($lUserHugo->getId());

    $this->assertEquals(2, count($lTokens));
  }


  public function testGetUsersAuthTokensWithPubblishing() {
    $lUserHugo = UserTable::getByIdentifier('hugo');
    $lTokens = AuthTokenTable::getAllTokensForPublishingByUser($lUserHugo->getId());

    $this->assertEquals(1, count($lTokens));
  }
}
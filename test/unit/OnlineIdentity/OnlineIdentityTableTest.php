<?php
require_once dirname(__file__).'/../../lib/BaseTestCase.php';

class  AuthTokenTableTest extends BaseTestCase {


  public static function setUpBeforeClass() {
    Doctrine::loadData(dirname(__file__).'/fixtures');
  }

  public function testRetrieveByIdentifier() {
    /*$c = new Community();
    $c->setCommunity("yiid");

    $o = new OnlineIdentity();
    $o->setIdentifier("hugo");
    $o->setIdentityType(OnlineIdentityTable::TYPE_IDENTITY);
    $o->setCommunity($c);
    $o->save();*/

    $result = OnlineIdentityTable::retrieveByIdentifier("hugo", "google", OnlineIdentityTable::TYPE_IDENTITY);

    $this->assertEquals('OnlineIdentity', get_class($result));
    $this->assertEquals("hugo", $result->getIdentifier());
  }


}
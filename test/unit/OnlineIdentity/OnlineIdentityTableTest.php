<?php
require_once dirname(__file__).'/../../lib/BaseTestCase.php';

/**
 * @author Matthias Pfefferle
 */
class  OnlineIdentityTableTest extends BaseTestCase {
  public static function setUpBeforeClass() {
    Doctrine::loadData(dirname(__file__).'/fixtures');
  }

  /**
   * @author Matthias Pfefferle
   */
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

  /**
   * @author Matthias Pfefferle
   */
  public function testExtractIdentifierfromUrl() {
    $lOnlineIdentity = OnlineIdentityTable::extractIdentifierfromUrl("http://google.de/profiles/hugo", null);

    $this->assertTrue("OnlineIdentity", get_class($lOnlineIdentity));
    $this->assertEquals("hugo", $lOnlineIdentity->getIdentifier());
  }
}
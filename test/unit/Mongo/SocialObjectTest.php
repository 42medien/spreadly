<?php
require_once dirname(__file__).'/../../lib/BaseTestCase.php';

class SocialObjectTest extends BaseTestCase {

  static public $aUserHugo = null;

  public static function setUpBeforeClass() {
    Doctrine::loadData(dirname(__file__).'/fixtures');
    self::$aUserHugo = UserTable::retrieveByUsername('hugo');
  }

  public function testSave() {
    parent::resetMongo();

    $lObject = SocialObjectTable::createSocialObject('http://affen.de', 'http://weyands.net', 'affen title', 'affen description', null);
    $lAliases = $lObject->getAlias();
    $this->assertTrue(is_object($lObject));
    $this->assertTrue(in_array(md5('http://weyands.net'), $lAliases));
    $this->assertFalse(in_array(md5('http://dasgehtschief.com'), $lAliases));
    $this->assertEquals('affen title', $lObject->getTitle());
  }



  public function testUpdateOnActivity() {
    parent::resetMongo();

    $lObject = SocialObjectTable::createSocialObject('http://affen.de', 'http://weyands.net', 'affen title', 'affen description', null);
    $lObject->updateObjectOnLikeActivity(1, 'http://nochmehraffen.com', 1);

    $lObject = SocialObjectTable::retrieveByUrl('http://affen.de');
    $this->assertEquals(1, $lObject->getLikeCount());
  }


  public function testAddAlias() {
    parent::resetMongo();

    $lObject = SocialObjectTable::createSocialObject('http://affen.de', 'http://weyands.net', 'affen title', 'affen description', null);
    $lObject->addAlias('http://www.snirgel.de');

    $lObject = SocialObjectTable::retrieveByUrl('http://affen.de');
    $lAliases = $lObject->getAlias();



    $this->assertTrue(is_object($lObject));
    $this->assertTrue(in_array(md5('http://www.snirgel.de'), $lObject->getAlias()));

  }
}
<?php
require_once dirname(__file__).'/../../lib/BaseTestCase.php';

class SocialObjectTableTest extends BaseTestCase {

  static public $aUserHugo = null;

  public static function setUpBeforeClass() {
    parent::resetMongo();
    Doctrine::loadData(dirname(__file__).'/fixtures');
  }


  public function testGetHot() {
    parent::resetMongo();
    Doctrine::loadData(dirname(__file__).'/fixtures');
    self::$aUserHugo = UserTable::retrieveByUsername('hugo');

    $lObject = SocialObjectTable::createSocialObject('http://affen.de', null, 'affen title', 'affen description', null);
    $lObject->updateObjectOnLikeActivity(array("1"), 'http://nochmehraffen.com', 1);
    $lObject->updateObjectOnLikeActivity(array("2"), 'http://nochmehraffen.com', 1);
    $lObject->updateObjectOnLikeActivity(array("3"), 'http://nochmehraffen.com', 1);

    $lObject2 = SocialObjectTable::createSocialObject('http://keineaffen.de', 'http://bim.bo', 'bim.bo title', 'bim.bo description', null);
    $lObject2->updateObjectOnLikeActivity(array("1"), 'http://bim.bo', 1);

    $lObject3 = SocialObjectTable::createSocialObject('http://spiegel.de', null, 'spiegel.de title', 'spiegel.de description', null);
    $lObject3->updateObjectOnLikeActivity(array("2"), 'http://spiegel.de', 1);
    $lObject3->updateObjectOnLikeActivity(array("1", "3"), 'http://spiegel.de', 1);

    $lObjects = SocialObjectTable::retrieveHotObjets(self::$aUserHugo->getId());
exit();die();
    $this->assertTrue(is_array($lObjects));
    $this->assertTrue(is_object($lObjects[1]));
    $this->assertEquals('spiegel.de title', $lObjects[3]->getTitle());

  }


  public function testGetHotByCommunity() {
    parent::resetMongo();
    Doctrine::loadData(dirname(__file__).'/fixtures');
    self::$aUserHugo = UserTable::retrieveByUsername('hugo');

    $lObjects = SocialObjectTable::retrieveHotObjets(self::$aUserHugo->getId(), null, 1);

    $this->assertTrue(is_array($lObjects));
    $this->assertTrue(is_object($lObjects[1]));
    $this->assertEquals('dem weyand sein blog', $lObjects[1]->getTitle());
  }


  public function testGetHotByFriendId() {
    parent::resetMongo();
    Doctrine::loadData(dirname(__file__).'/fixtures');
    self::$aUserHugo = UserTable::retrieveByUsername('hugo');

  }

}
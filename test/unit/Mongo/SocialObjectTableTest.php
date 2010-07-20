<?php
require_once dirname(__file__).'/../../lib/BaseTestCase.php';

class SocialObjectTableTest extends BaseTestCase {

  static public $aUserHugo = null;

  public static function setUpBeforeClass() {
    Doctrine::loadData(dirname(__file__).'/fixtures');
    self::$aUserHugo = UserTable::retrieveByUsername('hugo');
  }

  public function testSave() {
    parent::resetMongo();
  }


  public function testGetHot() {
    parent::resetMongo();

    $lObject = SocialObjectTable::createSocialObject('http://affen.de', 'http://weyands.net', 'affen title', 'affen description', null);
    $lObject->updateObjectOnLikeActivity(1, 'http://nochmehraffen.com', 1);
    $lObject->updateObjectOnLikeActivity(2, 'http://nochmehraffen.com', 1);
    $lObject->updateObjectOnLikeActivity(3, 'http://nochmehraffen.com', 1);

    $lObject2 = SocialObjectTable::createSocialObject('http://keineaffen.de', 'http://bim.bo', 'bim.bo title', 'bim.bo description', null);
    $lObject2->updateObjectOnLikeActivity(1, 'http://bim.bo', 1);

    $lObject3 = SocialObjectTable::createSocialObject('http://spiegel.de', null, 'spiegel.de title', 'spiegel.de description', null);
    $lObject3->updateObjectOnLikeActivity(1, 'http://spiegel.de', 1);
    $lObject3->updateObjectOnLikeActivity(1, 'http://spiegel.de', 1);


    $lObjects = SocialObjectTable::retrieveHotObjets();

    $this->assertTrue(is_array($lObjects));
    $this->assertTrue(is_object($lObjects[1]));
    $this->assertEquals('spiegel.de title', $lObjects[1]->getTitle());

  }

}
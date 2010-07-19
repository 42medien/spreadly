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
    $this->assertTrue(in_array(md5('http://weyands.net'),  explode(',',$lAliases)));
    $this->assertFalse(in_array(md5('http://dasgehtschief.com'),  explode(',',$lAliases)));
    $this->assertEquals('affen title', $lObject->getTitle());
  }
}
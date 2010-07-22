<?php
require_once dirname(__file__).'/../../lib/BaseTestCase.php';

class YiidActivityTest extends BaseTestCase {

  static public $aUserHugo = null;

  public static function setUpBeforeClass() {
    parent::resetMongo();
    Doctrine::loadData(dirname(__file__).'/fixtures');
    self::$aUserHugo = UserTable::retrieveByUsername('hugo');
  }

  public function testSave() {
    parent::resetMongo();
    $lActivity = new YiidActivity();
    $lActivity->url = 'http://www.affen22.de';
    $lActivity->setUId(self::$aUserHugo->getId());
    $this->assertTrue(is_array($lActivity->save()));
  }
}
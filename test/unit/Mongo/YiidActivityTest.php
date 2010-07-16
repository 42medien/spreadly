<?php
require_once dirname(__file__).'/../../lib/BaseTestCase.php';

class YiidActivityTest extends BaseTestCase {

  public static function setUpBeforeClass() {
    Doctrine::loadData(dirname(__file__).'/fixtures');
    $this->aUserHugo = UserTable::getByIdentifier('hugp');
  }


  public function testSave() {
    $lActivity = new YiidActivity();
    $lActivity->url = 'http://www.affen22.de';
    $lActivity->setUId(1);
    $lActivity->save();
  }
}
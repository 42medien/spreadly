<?php
require_once dirname(__file__).'/../../lib/BaseTestCase.php';

class PersistentVariableTableTest extends BaseTestCase {

  public function setUp() {
    //  $this->resetDB();
  }


  public function testSet() {
    $lUser = new User();
    $lUser->setUsername('hugo');
    $lUser->setActive(true);
    $this->assertTrue(is_object(PersistentVariableTable::set('affen', $lUser, true)));
  }


  public function testGet() {
    $lVar = PersistentVariableTable::get('affen');
    $this->assertTrue(is_object($lVar));
    $this->assertEquals(hugo, $lVar->getUsername());

    // 2nd run shall fail due not existing key
    $lVarFailed = PersistentVariableTable::get('dasgehtschief');
    $this->assertTrue(is_null($lVarFailed));
  }

  public function testRemove() {
    PersistentVariableTable::remove('affen');
    $this->assertTrue(is_null(PersistentVariableTable::retrieveByName('affen')));
  }
}
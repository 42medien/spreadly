<?php
require_once dirname(__file__).'/../../lib/BaseTestCase.php';

class UtilsTest extends BaseTestCase {

  public static function setUpBeforeClass() {
    //Doctrine::loadData(dirname(__file__).'/fixtures');
  }


  public function testFlattenArray() {
    $testArray = array(array(0 => 1), array(0 => 44));

    $this->assertTrue(is_array(HydrationUtils::flattenArray($testArray)));
    $this->assertEquals(2, count(HydrationUtils::flattenArray($testArray)));
    $this->assertEquals(array(1, 44), HydrationUtils::flattenArray($testArray));

  }
}
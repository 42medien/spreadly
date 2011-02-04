<?php
require_once dirname(__file__).'/../../lib/BaseTestCase.php';

class YiidActivityTest extends BaseTestCase {

  public static function setUpBeforeClass() {
    parent::resetMongo();
    Doctrine::loadData(dirname(__file__).'/fixtures');
  }


  public function testSaveLikeActivitys() {
    sfContext::getInstance()->getEventDispatcher()->connect("deal.event.approve", array('DealListener', 'updateMongoDeal'));

    $user = UserTable::getInstance()->findOneByUsername("hugo");
    $deal1 = DealTable::getInstance()->findOneBySummary("notizblog 1");

    $deal1->setStartDate(date("c", strtotime("-49 hours")));
    $deal1->setEndDate(date("c", strtotime("+3 days")));
    $deal1->saveInitialCoupons(array("single_code" => "xxxyyy"));
    $deal1->save();

    $deal1->approve();

    $this->assertTrue($deal1->isActive());

    $lObject = YiidActivityTable::saveLikeActivitys($user->getId(), "http://notizblog.org/about/", array(), YiidActivityTable::ACTIVITY_VOTE_POSITIVE, "like");

    $this->assertType("YiidActivity", $lObject);

    $lState = YiidActivityTable::saveLikeActivitys($user->getId(), "http://notizblog.org/about/", array(), YiidActivityTable::ACTIVITY_VOTE_POSITIVE, "like");

    $this->assertFalse($lState);

    sfProjectConfiguration::getActive()->getEventDispatcher()->connect("deal.event.pause", array('DealListener', 'updateMongoDeal'));

    $deal1->pause();
    $this->assertFalse($deal1->isActive());

    $lObject = YiidActivityTable::saveLikeActivitys($user->getId(), "http://notizblog.org/about/", array(), YiidActivityTable::ACTIVITY_VOTE_POSITIVE, "like");

    $this->assertType("YiidActivity", $lObject);

    $lState = YiidActivityTable::saveLikeActivitys($user->getId(), "http://notizblog.org/about/", array(), YiidActivityTable::ACTIVITY_VOTE_POSITIVE, "like");

    $this->assertFalse($lState);
  }
}
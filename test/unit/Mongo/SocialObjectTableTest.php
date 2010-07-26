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
    $lCommunityTwitter = CommunityTable::retrieveByCommunity('twitter');
    $lCommunityFb = CommunityTable::retrieveByCommunity('facebook');

    $lOiTwitter = OnlineIdentityTable::retrieveByIdentifier('hans_twitter', $lCommunityTwitter->getId());
    $lOiFb = OnlineIdentityTable::retrieveByIdentifier('hans_fb', $lCommunityFb->getId());



    $lObject = SocialObjectTable::createSocialObject('http://affen.de', null, 'affen title', 'affen description', null);
    $lObject->updateObjectOnLikeActivity(array($lOiTwitter->getId()), 'http://nochmehraffen.com', 1);
    $lObject->updateObjectOnLikeActivity(array($lOiFb->getId()), 'http://nochmehraffen.com', 1);

    $lObject2 = SocialObjectTable::createSocialObject('http://keineaffen.de', 'http://bim.bo', 'bim.bo title', 'bim.bo description', null);
    $lObject2->updateObjectOnLikeActivity(array($lOiTwitter->getId()), 'http://bim.bo', 1);

    $lObject3 = SocialObjectTable::createSocialObject('http://spiegel.de', null, 'spiegel.de title', 'spiegel.de description', null);
    $lObject3->updateObjectOnLikeActivity(array($lOiTwitter->getId(), $lOiFb->getId()), 'http://spiegel.de', 1);

    $lObjects = SocialObjectTable::retrieveHotObjets(self::$aUserHugo->getId());

    $this->assertTrue(is_array($lObjects));
    $this->assertTrue(is_object($lObjects[1]));

    // order affen title, bim.bo titlte , sppiegel.de title
    $this->assertEquals('spiegel.de title', $lObjects[2]->getTitle());

  }


  public function testGetHotByCommunity() {
    parent::resetMongo();
    Doctrine::loadData(dirname(__file__).'/fixtures');
    self::$aUserHugo = UserTable::retrieveByUsername('hugo');
    $lCommunityTwitter = CommunityTable::retrieveByCommunity('twitter');
    $lCommunityFb = CommunityTable::retrieveByCommunity('facebook');

    $lOiTwitter = OnlineIdentityTable::retrieveByIdentifier('hans_twitter', $lCommunityTwitter->getId());
    $lOiFb = OnlineIdentityTable::retrieveByIdentifier('hans_fb', $lCommunityFb->getId());

    $lObject = SocialObjectTable::retrieveByUrl('http://weyands.net');
    $lObject->updateObjectOnLikeActivity(array($lOiTwitter->getId()), 'http://nochmehraffen.com', 1);
    $lObject->updateObjectOnLikeActivity(array($lOiFb->getId()), 'http://nochmehraffen.com', 1);


    $lObjects = SocialObjectTable::retrieveHotObjets(self::$aUserHugo->getId(), null, 1);

    $this->assertTrue(is_array($lObjects));
    $this->assertTrue(is_object($lObjects[0]));
    $this->assertEquals('dem weyand sein blog', $lObjects[0]->getTitle());
  }


  public function testGetHotByFriendId() {
    parent::resetMongo();
    Doctrine::loadData(dirname(__file__).'/fixtures');
    $aUserHugo = UserTable::retrieveByUsername('hugo');
    $aUserHans =  UserTable::retrieveByUsername('hans');

    $lCommunityTwitter = CommunityTable::retrieveByCommunity('twitter');
    $lCommunityFb = CommunityTable::retrieveByCommunity('facebook');

    $lOiTwitter = OnlineIdentityTable::retrieveByIdentifier('hans_twitter', $lCommunityTwitter->getId());
    $lOiFb = OnlineIdentityTable::retrieveByIdentifier('hans_fb', $lCommunityFb->getId());

    $lObject = SocialObjectTable::createSocialObject('http://affen.de', null, 'affen title', 'affen description', null);
    $lObject->updateObjectOnLikeActivity(array($lOiTwitter->getId()), 'http://nochmehraffen.com', 1);
    $lObject->updateObjectOnLikeActivity(array($lOiFb->getId()), 'http://nochmehraffen.com', 1);

    $lObject2 = SocialObjectTable::createSocialObject('http://keineaffen.de', 'http://bim.bo', 'bim.bo title', 'bim.bo description', null);
    $lObject2->updateObjectOnLikeActivity(array($lOiTwitter->getId()), 'http://bim.bo', 1);

    $lObject3 = SocialObjectTable::createSocialObject('http://spiegel.de', null, 'spiegel.de title', 'spiegel.de description', null);
    $lObject3->updateObjectOnLikeActivity(array($lOiTwitter->getId(), $lOiFb->getId()), 'http://spiegel.de', 1);


    $lObjects = SocialObjectTable::retrieveHotObjets($aUserHugo->getId(), $aUserHans->getId(), null);

    $this->assertTrue(is_array($lObjects));
    $this->assertTrue(is_object($lObjects[0]));
    $this->assertEquals('http://affen.de', $lObjects[0]->getUrl());

  }

}
<?php
require_once dirname(__file__).'/../../lib/BaseTestCase.php';

/**
 * @author Matthias Pfefferle
 */
class  OnlineIdentityTableTest extends BaseTestCase {
  public static function setUpBeforeClass() {
    Doctrine::loadData(dirname(__file__).'/fixtures');
  }

  /**
   * @author Matthias Pfefferle
   */
  public function testRetrieveByIdentifier() {
    $lCommunity = CommunityTable::getInstance()->findBy("community", "google");
    $lCommunity = $lCommunity[0];

    $result = OnlineIdentityTable::retrieveByIdentifier("hugo", $lCommunity->getId(), OnlineIdentityTable::TYPE_IDENTITY);

    $this->assertEquals('OnlineIdentity', get_class($result));
    $this->assertEquals("hugo", $result->getIdentifier());
  }

  /**
   * @author Matthias Pfefferle
   */
  public function testExtractIdentifierfromUrl() {
    $lOnlineIdentity = OnlineIdentityTable::extractIdentifierfromUrl("http://google.de/profiles/hugo", null);

    $this->assertEquals("OnlineIdentity", get_class($lOnlineIdentity));
    $this->assertEquals("hugo", $lOnlineIdentity->getIdentifier());

    $lCommunity = CommunityTable::getInstance()->findBy("community", "google_de");
    $lCommunity = $lCommunity[0];

    $lOnlineIdentity = OnlineIdentityTable::extractIdentifierfromUrl("http://www.google.de/profiles/hugo", $lCommunity->getId());

    $this->assertEquals("OnlineIdentity", get_class($lOnlineIdentity));
    $this->assertEquals("hugo", $lOnlineIdentity->getIdentifier());
    $this->assertEquals("google_de", $lOnlineIdentity->getCommunity()->getCommunity());
  }

  /**
   * @author Matthias Pfefferle
   */
  public function testAddOnlineIdentity() {
    $lCommunity = CommunityTable::getInstance()->findBy("community", "google");
    $lCommunity = $lCommunity[0];

    $lCommunityId = $lCommunity->getId();

    $lOI = Doctrine_Query::create()->
    from('OnlineIdentity oi')->
    where('oi.identifier = ? AND oi.community_id = ?', array("hugo", $lCommunityId))->
    fetchOne();

    $lOITest = OnlineIdentityTable::addOnlineIdentity('hugo', $lCommunityId, OnlineIdentityTable::TYPE_IDENTITY);

    $this->assertEquals($lOI->getId(), $lOITest->getId());
  }

  public function testAddOnlineIdentity3() {
    $lCommunity = CommunityTable::getInstance()->findBy("community", "google_de");
    $lCommunity = $lCommunity[0];

    $lOITest = OnlineIdentityTable::addOnlineIdentity('ekaabo-GmbH', $lCommunity->getId(), OnlineIdentityTable::TYPE_IDENTITY);

    $this->assertEquals('OnlineIdentity', get_class($lOITest));
    $this->assertEquals('ekaabo-GmbH', $lOITest->getIdentifier());
    $this->assertEquals(OnlineIdentityTable::TYPE_IDENTITY, $lOITest->getIdentityType());
  }

  public function testAddOnlineIdentity4() {
    $lCommunity = CommunityTable::getInstance()->findBy("community", "facebook");
    $lCommunity = $lCommunity[0];

    $identity = 'ichbrauchnenlangennamendassernichtindenfixturesauftaucht';
    $lOITest = OnlineIdentityTable::addOnlineIdentity($identity, $lCommunity->getId(), OnlineIdentityTable::TYPE_ACCOUNT);

    $this->assertEquals($identity, $lOITest->getIdentifier());
    $this->assertEquals(OnlineIdentityTable::TYPE_ACCOUNT, $lOITest->getIdentityType());
  }

  public function testAddOnlineIdentity6() {
    $lCommunity = CommunityTable::getInstance()->findBy("community", "facebook");
    $lCommunity = $lCommunity[0];

    $identity = 'http://www.facebook.com/downloads';
    $lOITest = OnlineIdentityTable::addOnlineIdentity($identity, $lCommunity->getId(), OnlineIdentityTable::TYPE_URL);

    $this->assertEquals($identity, $lOITest->getIdentifier());
    $this->assertEquals(OnlineIdentityTable::TYPE_URL, $lOITest->getIdentityType());
  }

  public function testDetermineIdentifier() {
    $pIdentifier = 'http://www.google.com/profiles/affenkopf';

    $lIdentity = OnlineIdentityTable::extractIdentifierfromUrl($pIdentifier, null);

    $this->assertEquals('affenkopf', $lIdentity->getIdentifier());
    $this->assertEquals('google', $lIdentity->getCommunity()->getCommunity());
  }




  public function testGetIdentitysConnectedToOi() {
    $lCommunity = CommunityTable::getInstance()->findBy("community", "google");
    $lCommunity = $lCommunity[0];

    $result = OnlineIdentityTable::retrieveByIdentifier("hugo", $lCommunity->getId(), OnlineIdentityTable::TYPE_IDENTITY);


    $this->assertEquals("hugo", $result->getIdentifier());

    $lConnectedIds = OnlineIdentityConTable::getIdentitysConnectedToOi($result->getId());

    $this->assertTrue(is_array($lConnectedIds));
    $this->assertEquals('OnlineIdentity', get_class(OnlineIdentityTable::getInstance()->find($lConnectedIds[0])));


  }

  /*
   public function testDetermineIdentifier2() {
   $pService = 'testcommunity';
   $pIdentifier = 'affenkopf';

   $lIdentArray = OnlineIdentityPeer::determineIdentifier($pIdentifier, $pService);
   $pIdentifier = $lIdentArray['identifier'];
   $pService =  $lIdentArray['service'];

   $this->assertEquals('affenkopf', $pIdentifier);
   $this->assertEquals('testcommunity', $pService->getCommunity());
   }

   /**
   * @expectedException HttpException
   *//*
   public function testAddOnlineIdentity2() {
   $lOITest = OnlineIdentityTable::addOnlineIdentity('affenkopf', 'testcommunity', OnlineIdentityTable::TYPE_IDENTITY);
   }*/
  /**
   * @expectedException ModelException
   *//*
   public function testAddOnlineIdentity5() {
   $identity = 'http://pfefferle.org';
   $lOITest = OnlineIdentityPeer::addOnlineIdentity($identity, 'account', OnlineIdentityPeer::TYPE_URL);
   }*/
}
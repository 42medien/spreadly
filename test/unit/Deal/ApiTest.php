<?php
/*
 * Call like this:
 * phpunit ./test/unit/Deal/DealTest.php
 * phpunit --filter testTruth ./test/unit/Deal/DealTest.php
 */
require_once dirname(__file__).'/../../lib/BaseTestCase.php';

class DealTest extends BaseTestCase {

  private static $VALID_TEST_JSON = '{
     "name": "Kampagne XY",

     "motivation": {
      "title": "Toll alles für umme",
      "text": "Blablabla"
     },

     "spread": {
      "title": "Guckt mal Leute, supidupi.",
      "text": "Blablabla",
      "url": "http://share.this.com",
      "img": "http://share.this.com/spread.jpg",
      "tos": "http://share.this.com/tos"
     },

     "coupon": {
      "type": "code|unique_code|url|download",
      "title": "Hier ist dein Deal",
      "text": "Blablabla",
      "code": "XYZABC",
      "url": "http://share.this.com/url",
      "webhook_url": "http://share.this.com/webhook",
      "redeem_url": "http://share.this.com/redeem"
     },

     "billing": {
      "type": "like|media_penetration",
      "target_quantity": 10
     }
    }';

   private static $INVALID_TEST_JSON = '{
     "name": "Kampagne XY",

     "spread": {
      "title": "Guckt mal Leute, supidupi.",
      "text": "Blablabla",
      "url": "share.this.com",
      "img": "http://share.this.com/spread.jpg",
      "tos": "http://share.this.com/tos"
     },

     "coupon": {
      "type": "code|unique_code|url|download",
      "title": "Hier ist dein Deal",
      "text": "Blablabla",
      "code": "XYZABC",
      "url": "http://share.this.com/url",
      "webhook_url": "http://share.this.com/webhook",
      "redeem_url": "http://share.this.com/redeem"
     },

     "billing": {
      "type": "like|media_penetration",
      "target_quantity": 10
     }
    }';

  /**
   * @expectedException HttpException
   */
  public function testWrongRequest() {
    UrlUtils::getUrlContent("http://api.spreadly.local/deals");
  }

  /**
   * @expectedException HttpException
   */
  public function testMissingAccessToken() {
    $data = UrlUtils::getUrlContent("http://api.spreadly.local/deals", UrlUtils::HTTP_POST, self::$VALID_TEST_JSON);
  }

  public function testValidRequest() {
    $user = Doctrine_Core::getTable('sfGuardUser')->createQuery('u')->where('u.is_active = ?', true)->fetchOne();

    $data = UrlUtils::getUrlContent("http://api.spreadly.local/deals?access_token=".$user->getAccessToken(), UrlUtils::HTTP_POST, self::$VALID_TEST_JSON);

    $data = json_decode($data, true);

    $this->assertEquals("200", $data['success']['code']);
  }

  public function testDealFromJson() {
    $d = new Deal();
    $data = json_decode(self::$VALID_TEST_JSON, true);
    $d->fromApiArray($data);

    $this->assertEquals($data['name'], $d->getName());
    $this->assertEquals($data['motivation']['title'], $d->getMotivationTitle());
    $this->assertEquals($data['motivation']['text'], $d->getMotivationText());
    $this->assertEquals($data['spread']['title'], $d->getSpreadTitle());
    $this->assertEquals($data['spread']['text'], $d->getSpreadText());
    $this->assertEquals($data['spread']['url'], $d->getSpreadUrl());
    $this->assertEquals($data['spread']['img'], $d->getSpreadImg());
    $this->assertEquals($data['spread']['tos'], $d->getSpreadTos());
    $this->assertEquals($data['coupon']['type'], $d->getCouponType());
    $this->assertEquals($data['coupon']['title'], $d->getCouponTitle());
    $this->assertEquals($data['coupon']['text'], $d->getCouponText());
    $this->assertEquals($data['coupon']['code'], $d->getCouponCode());
    $this->assertEquals($data['coupon']['url'], $d->getCouponUrl());
    $this->assertEquals($data['coupon']['webhook_url'], $d->getCouponWebhookUrl());
    $this->assertEquals($data['coupon']['redeem_url'], $d->getCouponRedeemUrl());
    $this->assertEquals($data['billing']['type'], $d->getBillingType());
    $this->assertEquals($data['billing']['target_quantity'], $d->getTargetQuantity());
  }

  public function testInvalidRequest() {
    $user = Doctrine_Core::getTable('sfGuardUser')->createQuery('u')->where('u.is_active = ?', true)->fetchOne();

    $data = UrlUtils::sendPostRequest("http://api.spreadly.local/deals?access_token=".$user->getAccessToken(), self::$INVALID_TEST_JSON);

    $data = json_decode($data, true);

    $this->assertEquals("406", $data['error']['code']);
  }
}
?>
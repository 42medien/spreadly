<?php
/*
 * Call like this:
 * phpunit ./test/unit/Deal/DealTest.php
 * phpunit --filter testTruth ./test/unit/Deal/DealTest.php
 */
require_once dirname(__file__).'/../../lib/BaseTestCase.php';

class DealTest extends BaseTestCase {

  private static $VALID_TEST_JSON = "{
      name: 'Kampagne XY',

      motivation: {
        title: 'Toll alles für umme',
        text: 'Blablabla'
      },

      spread: {
        title: 'Guckt mal Leute, supidupi.',
        text: 'Blablabla',
        url: 'http://share.this.com',
        img: 'http://share.this.com/spread.jpg',
        tos: 'http://share.this.com/tos'
      },

      coupon: {
        type: 'code|unique_code|url|download',
        title: 'Hier ist dein Deal',
        text: 'Blablabla',
        code: 'XYZABC',
        url: '',
        webhook_url: '',
        redeem_url: 'http://share.this.com/redeem'
      },

      billing: {
        type: 'like|media_penetration',
        target_quantity: 10
      }
    }";

  /**
   * @expectedException HttpException
   */
  public function testWrongRequest() {
    UrlUtils::getUrlContent("http://api.spreadly.local/deals");
  }

  public function testValidRequest() {
    $data = UrlUtils::getUrlContent("http://api.spreadly.local/deals", UrlUtils::HTTP_POST, self::$VALID_TEST_JSON);

    $data = json_decode($data, true);

    $this->assertEquals("200", $data['success']['code']);
  }
}
?>
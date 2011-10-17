<?php
/**
 * Enter description here...
 *
 */
class CouponWebhookClient {
  /**
   * Enter description here...
   *
   * @param string $url
   */
  public static function requestCoupon($url) {
    $json = UrlUtils::sendGetRequest($url);

    // check json
    if ($coupon = json_decode($json, true)) {
      // check coupon-code
      if (array_key_exists("coupon", $coupon) && array_key_exists("code", $coupon["coupon"])) {
        return $coupon["coupon"]["code"];
      }
    }

    sfContext::getInstance()->getEventDispatcher()->notify(new sfEvent($url, 'deal.event.invalid_webhook'));
    throw new sfException("invalid webhook");
  }
}
?>
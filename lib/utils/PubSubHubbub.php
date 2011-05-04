<?php
/**
 * a class to handle the pubsubhubbub like push api
 *
 * @author Matthias Pfefferle
 */
class PubSubHubbub {

  /**
   * verify a callback url
   *
   * @param string $topic
   * @param string $callback
   */
  public static function verifyCallback($topic, $callback) {
    $challange = mt_rand();

    $separator = "?";
    if (strpos($callback,"?")!=false)
      $separator = "&";

    $url = $callback.$separator."hub.mode=subscribe&hub.topic=$topic&hub.challenge=$challange";

    // add any additional curl options here
    $options = array(CURLOPT_URL => $url,
                     CURLOPT_USERAGENT => "Spread.ly-Push-API/1.0",
                     CURLOPT_RETURNTRANSFER => true);

    $ch = curl_init();
    curl_setopt_array($ch, $options);

    $response = curl_exec($ch);
    $info = curl_getinfo($ch);

    // all good -- anything in the 200 range
    if (substr($info['http_code'],0,1) == "2" && $response == $challange) {
      return true;
    }

    return false;
  }
}
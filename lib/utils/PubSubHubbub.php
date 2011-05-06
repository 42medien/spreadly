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
   * @param string $topic the domain a user want to subscribe to, for example: $DomainProfile->getDomain()
   * @param string $callback
   */
  public static function verifyCallback($topic, $callback) {
    $challenge = mt_rand();

    $separator = "?";
    if (strpos($callback,"?")!=false)
      $separator = "&";

    $url = $callback.$separator."hub.mode=subscribe&hub.topic=$topic&hub.challenge=$challenge";

    // add any additional curl options here
    $options = array(CURLOPT_URL => $url,
                     CURLOPT_USERAGENT => "Spread.ly-Push-API-Verifier/1.0",
                     CURLOPT_RETURNTRANSFER => true);

    $ch = curl_init();
    curl_setopt_array($ch, $options);

    $response = curl_exec($ch);
    $info = curl_getinfo($ch);
    // all good -- anything in the 200 range
    if (substr($info['http_code'],0,1) == "2" && $response == $challenge) {
      return true;
    }
    return $info['http_code'];
  }

  public static function push($callback, $post_body, $post_header) {
    $ch = curl_init($callback);
    curl_setopt($ch, CURLOPT_POST,           1);
    curl_setopt($ch, CURLOPT_POSTFIELDS,     $post_body);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_HEADER,         1);  // DO NOT RETURN HTTP HEADERS
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  // RETURN THE CONTENTS OF THE CALL
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
    curl_setopt($ch, CURLOPT_VERBOSE,        1);
    curl_setopt($ch, CURLOPT_HTTPHEADER,     $post_header);

    $response = curl_exec($ch);
    $info = curl_getinfo($ch);

    return $info;
  }
}
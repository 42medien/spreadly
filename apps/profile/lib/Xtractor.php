<?php
/**
 * class to extract the subdomain to get the page-user
 * for example: http://hugo.yiid.com/
 *
 * @author Matthias Pfefferle
 */
class Xtractor {

  /**
   * extracts the subdomain
   *
   * @param sfWebRequest $pRequest
   * @return string the subdomain
   */
  public static function extractSubdomain(sfWebRequest $pRequest) {
    $lSubdomain = null;
    $m = array();
    $lReggExp = str_replace(array(".", "http://www"), array("\.", "(\w+)"), sfConfig::get('app_settings_url'));
    preg_match("/^$lReggExp/", $pRequest->getHost(), $m );

    preg_match("/^(\w+)\.yiid\.net/", $pRequest->getHost(), $n );

    if (count($m) > 1 && $m[1] != 'www') {
      $lSubdomain = $m[1];
    } else if (count($n) > 1 && $n[1] != 'www') {
      $lSubdomain = $n[1];
    } else {
      $lSubdomain = "hugo";
    }

    return $lSubdomain;
  }

  /**
   * function to get a yiid user through the extracted subdomain
   *
   * @param sfWebRequest $pRequest
   * @return User|null
   */
  public static function getUser(sfWebRequest $pRequest) {
    $lSubdomain = self::extractSubdomain($pRequest);
    return UserPeer::getUserByUsername($lSubdomain);
  }
}
?>
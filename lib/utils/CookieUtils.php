<?php
class CookieUtils {


  const COOKIENAME = 'yiidservices';
  const SERVICE_TIMESTAMP_COOKIE = 'yiidservices_timecheck';

  /**
   * generates a cookie with all identities owned by the user.
   * usually called on signin & adding a new identity
   *
   * @author Christian Weyand
   * @param $pIdentitys
   * @return unknown_type
   */
  public static function generateWidgetIdentityCookie($pIdentitys) {
    $lCookie = array();
    $i = 0;

    foreach ($pIdentitys as $lIdentity) {
      $lCookie[] = array('index' => $i, 'oi_id' => $lIdentity->getId(), 'name' => $lIdentity->getCommunity()->getCommunity(), 'active' => $lIdentity->getSocialPublishingEnabled(), 'identifier' => $lIdentity->getIdentifier() );
      $i++;
    }

    //To Serialise Call :
    $string = json_encode($lCookie);

    setcookie(self::COOKIENAME, $string, time() + 15552000, '/', sfConfig::get('app_settings_host'));
    setcookie(self::SERVICE_TIMESTAMP_COOKIE, time(), time() + 15552000, '/', sfConfig::get('app_settings_host'));
  }


  /**
   * removes identity cookie
   *
   * @author Christian Weyand
   */
  public static function removeWidgetIdentityCookie() {
    setcookie(self::COOKIENAME, '', time()-3600, '/', sfConfig::get('app_settings_host'));
  }

  /**
   * returns a storage param from the factories.yml
   *
   * @author Matthias Pfefferle
   * @param string $pParamKey
   * @return string|null
   */
  public static function getStorageParam($pParamKey) {
    $lAppConfiguration = ProjectConfiguration::getApplicationConfiguration(sfConfig::get("sf_app"), sfConfig::get("sf_environment"), false);
    $lFactory = sfFactoryConfigHandler::getConfiguration($lAppConfiguration->getConfigPaths('config/factories.yml'));

    $lStorageParams = $lFactory['storage']['param'];

    if (array_key_exists($pParamKey, $lStorageParams)) {
      return $lStorageParams[$pParamKey];
    } else {
      return null;
    }
  }

  public static function getSessionId() {
    $lSessionName = self::getStorageParam("session_name");

    return session_id($lSessionName);
  }
}


////   http://de.php.net/setrawcookie
/// http://stackoverflow.com/questions/2692371/storing-nested-arrays-in-a-cookie

?>
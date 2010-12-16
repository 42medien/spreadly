<?php
class CdnSingleton {

  static private $aHostNumber = 0;
  static private $aHosts = array();
  static private $aHostCount = 0;
  static private $gZip = false;

  static private $aInstance = null;

  /**
   * singleton logic
   *
   * @return self
   */
  static public function getInstance() {
    if (null === self::$aInstance) {
      self::$aInstance = new self;
      self::$aHosts = sfConfig::get('app_amazons3_hosts');
      self::$aHostCount = count(self::$aHosts);

      $encodings=array_key_exists('HTTP_ACCEPT_ENCODING', $_SERVER) ? $_SERVER['HTTP_ACCEPT_ENCODING'] : false;
      if (preg_match('/(gzip|deflate)/i',$encodings) && sfConfig::get('app_settings_gzip', 1) && !(preg_match('/safari/i',$_SERVER["HTTP_USER_AGENT"])) ) {
        self::$gZip = true;
      }

    }

    return self::$aInstance;
  }

  /**
   * disable constructor and clone to not constrain users
   * to use getInstance
   *
   * @see getInstance()
   */
  private function __construct(){}
  private function __clone(){}


  public function getNextHost() {
    if (self::$aHostNumber >= self::$aHostCount) {
      self::$aHostNumber = 0;
    }
    return self::$aHosts[self::$aHostNumber++];
  }

  public function isGzipped() {
    return self::$gZip?'.gz':'';
  }
}


?>
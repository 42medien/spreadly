<?php
/**
 * memcache manager class
 *
 * @author Matthias Pfefferle
 * @author Christian Weyand
 * @author Sixgroups
 */
class MemcacheManager {

  private static $instance = null;
  private $dummyCacheDriver = null;

  // Make sure that, if you define new buckets here, they are set up in memcache.yml!
  const DEFAULT_BUCKET = 'default',
  USER_BUCKET = 'users',
  COMMUNITY_BUCKET = 'communities',
  SHOUT_BUCKET = 'shouts',
  SERVICE_BUCKET = 'services',
  PCODE_BUCKET = 'pcodes',
  SESSION_BUCKET = 'sessions',

  DEFAULT_NS = 'yiid',
  USER_ID_NS = 'user/id',
  USER_USERNAME_NS = 'user/username',
  COMMUNITY_ID_NS = 'community/id',
  COMMUNITY_FORUM_NS = 'community/forum',
  SHOUT_ID_NS = 'shout/id',
  SERVICE_ID_NS = 'service/id',
  PCODE_ID_NS = 'pcode/id',
  SESS_ID_NS = 'session/id';

  public $cache;

  /**
   * Prevent constructor (Singleton)
   */
  private function __construct() {}

  /**
   * prevent cloning (Singleton)
   */
  private function __clone() {}

  /**
   * get Instance (Singleton)
   *
   * @return MemcacheManager
   */
  public static function getInstance() {
    if ( self::$instance == null ) {
      self::$instance = new MemcacheManager();
    }
    if(self::$instance->cache == null){
      self::$instance->setup();
    }
    return self::$instance;
  }

  /**
   * generic funtion to store atomic vals inside memcache
   *
   * @param String $key
   * @param String $value
   * @param String $ns
   * @param String $bucket deprecated
   */
  public static function store($key, $value, $ns=self::DEFAULT_NS, $bucket=self::DEFAULT_BUCKET){
    $cache = MemcacheManager::getInstance()->cache;
    $cache->set($key, $value);
  }

  /**
   * retrieve a simple key/value pair from memcache
   *
   * @param String $key
   * @param String_type $ns
   * @param String $bucket
   */
  public static function retrieve($key, $ns=self::DEFAULT_NS, $bucket=self::DEFAULT_BUCKET){
    $cache = MemcacheManager::getInstance()->cache;
    $cache->setBucket($bucket);
    $value = $cache->get($key);
    if($value){
      return $value;
    }
  }

  /**
   * sets up the memcache buckets and servers so they are availaibale in the application (custom mecache inplementation)
   * @return unknown_type
   */
  public function setup() {
    //sfContext::getInstance()->getLogger()->log('{sgMemcache} setup sgMemcache '); does not work if on cli
    try {
      //      if (sfConfig::get('app_memcache_queries')
      //      || sfConfig::get('app_memcache_results')
      //      || sfConfig::get('app_memcache_objects')) {
      //        //echo "env:".sfConfig::get('sf_environment');

      $this->cache = new sfMemcacheCache(sfConfig::get('sf_factory_view_cache_parameters', array (
          'automatic_cleaning_factor' => 0,
          'cache_dir' => sfConfig::get('sf_cache_dir'),
          'lifetime' => 86400,
          'prefix' => 'object_cache',
          'servers' => array (
              'default' => array (
                'host' => sfConfig::get('app_memcache_server_ip'),
                'port' => 11211,
              ),
          ),
      )));

      // for fixtures
      try {
        sfContext::getInstance()->getLogger()->log('{yiidMemCache} setup yiidMemCache '); //does not work if on cli
      } catch (Exception $e) {}
      // }
    }
    catch (Exception $e){
      // for fixtures
      try {
        sfContext::getInstance()->getLogger()->crit('{sgMemcache} memcache initialization failed: '.$e->getMessage());
      } catch (Exception $e) {}
    }
  }

  public function getCache() {
    return $this->cache;
  }
}
?>
<?php

require_once dirname(__FILE__).'/../lib/vendor/symfony/lib/autoload/sfCoreAutoload.class.php';
sfCoreAutoload::register();

class ProjectConfiguration extends sfProjectConfiguration {
  public function setup() {
    $this->enablePlugins('sfDoctrinePlugin', 'yiidgeneralPlugin');
  }

  public function configureDoctrine(Doctrine_Manager $manager) {
    $servers = array(
      'host' => sfConfig::get('app_memcache_server_ip'),
      'port' => 11211,
      'persistent' => true
    );

    $cacheDriver = new Doctrine_Cache_Memcache(
      array(
        'servers' => $servers,
        'compression' => false
      )
    );

    //enable Doctrine cache
    $manager->setAttribute(Doctrine::ATTR_RESULT_CACHE, $cacheDriver);

    $manager->setCollate('utf8_unicode_ci');
    $manager->setCharset('utf8');
  }
}

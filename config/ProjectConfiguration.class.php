<?php

require_once dirname(__FILE__).'/../lib/vendor/symfony/lib/autoload/sfCoreAutoload.class.php';
sfCoreAutoload::register();

class ProjectConfiguration extends sfProjectConfiguration {
  public function setup() {
    $this->connectEventListeners();
    
    sfConfig::set( 'sf_upload_dir_name', 'uploads' );

    $this->enablePlugins(array(
      'sfDoctrinePlugin',
      'yiidPlugin',
      'sfFormExtraPlugin',
      'sfImageTransformPlugin',
      'sfDoctrineGuardPlugin',
      'sfForkedDoctrineApplyPlugin'
    ));
  }
  
  public function configureDoctrine(Doctrine_Manager $manager) {
    // yiid activity dispatcher
    $this->dispatcher->connect('new-yiid-activity', array('StatsFeeder', 'track'));

    $manager->setCollate('utf8_unicode_ci');
    $manager->setCharset('utf8');
  }

  private function connectEventListeners() {
    // Register listeners for Deal events
    $prefix = "deal.event.";

    $this->dispatcher->connect('deal.changed', array('DealListener', 'updateMongoDeal'));

    $this->dispatcher->connect($prefix.'submit', array('DealListener', 'updateMongoDeal'));
    $this->dispatcher->connect($prefix.'approve', array('DealListener', 'updateMongoDeal'));
    $this->dispatcher->connect($prefix.'deny', array('DealListener', 'updateMongoDeal'));
    $this->dispatcher->connect($prefix.'pause', array('DealListener', 'updateMongoDeal'));
    $this->dispatcher->connect($prefix.'resume', array('DealListener', 'updateMongoDeal'));
    $this->dispatcher->connect($prefix.'trash', array('DealListener', 'updateMongoDeal'));

    $this->dispatcher->connect($prefix.'submit', array('DealListener', 'eventSubmit'));
    $this->dispatcher->connect($prefix.'approve', array('DealListener', 'eventApprove'));
    $this->dispatcher->connect($prefix.'deny', array('DealListener', 'eventDeny'));    
  }
}

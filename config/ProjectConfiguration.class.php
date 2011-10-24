<?php
require_once dirname(__FILE__).'/../lib/vendor/symfony/lib/autoload/sfCoreAutoload.class.php';
sfCoreAutoload::register();

// doctrine 2 class loader
require_once dirname(__FILE__).'/../lib/vendor/Doctrine/Common/ClassLoader.php';

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

    // load common doctrine 2 files
    $classLoader = new Doctrine\Common\ClassLoader('Doctrine\Common', dirname(__FILE__).'/../lib/vendor');
    $classLoader->register();

    // load mongo odm mapper
    $classLoader = new Doctrine\Common\ClassLoader('Doctrine\ODM\MongoDB', dirname(__FILE__).'/../lib/vendor');
    $classLoader->register();

    // load mongodb libs
    $classLoader = new Doctrine\Common\ClassLoader('Doctrine\MongoDB', dirname(__FILE__).'/../lib/vendor');
    $classLoader->register();

    // load some symfony 2 files
    $classLoader = new Doctrine\Common\ClassLoader('Symfony', dirname(__FILE__).'/../lib/vendor');
    $classLoader->register();

    // load mongo-documents
    $classLoader = new Doctrine\Common\ClassLoader('Documents', dirname(__FILE__).'/../lib/mongo');
    $classLoader->register();

    // load mongo-documents
    $classLoader = new Doctrine\Common\ClassLoader('Repositories', dirname(__FILE__).'/../lib/mongo');
    $classLoader->register();

    // load queue stuff
    $classLoader = new Doctrine\Common\ClassLoader('Queue', dirname(__FILE__).'/../lib');
    $classLoader->register();
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

    $this->dispatcher->connect($prefix.'submit', array('DealListener', 'eventSubmit'));
    $this->dispatcher->connect($prefix.'approve', array('DealListener', 'eventApprove'));
    $this->dispatcher->connect($prefix.'deny', array('DealListener', 'eventDeny'));
    $this->dispatcher->connect($prefix.'expire', array('DealListener', 'eventExpire'));

    $this->dispatcher->connect($prefix.'deactivate', array('DealListener', 'eventInvalidWebhook'));
  }
}

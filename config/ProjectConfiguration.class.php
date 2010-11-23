<?php

require_once dirname(__FILE__).'/../lib/vendor/symfony/lib/autoload/sfCoreAutoload.class.php';
sfCoreAutoload::register();

class ProjectConfiguration extends sfProjectConfiguration {
  public function setup() {
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
}

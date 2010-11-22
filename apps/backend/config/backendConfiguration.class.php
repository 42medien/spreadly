<?php
class backendConfiguration extends sfApplicationConfiguration
{
  public function configure()
  {
  }

  public function setup()
  {
    $this->enablePlugins(array(
      'sfDoctrinePlugin',
      'sfDoctrineGuardPlugin',
      'sfForkedDoctrineApplyPlugin'
    ));
  }
}

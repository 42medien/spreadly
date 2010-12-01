<?php
class backendConfiguration extends sfApplicationConfiguration
{
  public function configure()
  {
    // Register listeners for Deal events
    $prefix = "deal.event.";
    $this->dispatcher->connect($prefix.'submit', array('DealListener', 'eventSubmit'));
    $this->dispatcher->connect($prefix.'approve', array('DealListener', 'eventApprove'));
    $this->dispatcher->connect($prefix.'deny', array('DealListener', 'eventDeny'));
    $this->dispatcher->connect($prefix.'pause', array('DealListener', 'eventPause'));
    $this->dispatcher->connect($prefix.'resume', array('DealListener', 'eventResume'));
    $this->dispatcher->connect($prefix.'trash', array('DealListener', 'eventTrash'));
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

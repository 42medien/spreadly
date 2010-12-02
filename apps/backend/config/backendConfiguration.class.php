<?php
class backendConfiguration extends sfApplicationConfiguration
{
  public function configure()
  {
    // Register listeners for Deal events
    $prefix = "deal.event.";
    $this->dispatcher->connect($prefix.'approve', array('DealListener', 'eventApprove'));
    $this->dispatcher->connect($prefix.'deny', array('DealListener', 'eventDeny'));

    $this->dispatcher->connect($prefix.'submit', array('DealListener', 'updateMongoDeal'));
    $this->dispatcher->connect($prefix.'approve', array('DealListener', 'updateMongoDeal'));
    $this->dispatcher->connect($prefix.'deny', array('DealListener', 'updateMongoDeal'));
    $this->dispatcher->connect($prefix.'pause', array('DealListener', 'updateMongoDeal'));
    $this->dispatcher->connect($prefix.'resume', array('DealListener', 'updateMongoDeal'));
    $this->dispatcher->connect($prefix.'trash', array('DealListener', 'updateMongoDeal'));

    $this->dispatcher->connect('deal.couponQuantityChanged', array('DealListener', 'updateMongoDeal'));
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

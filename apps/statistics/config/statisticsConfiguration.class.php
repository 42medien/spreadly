<?php

class statisticsConfiguration extends sfApplicationConfiguration
{
  protected $aStatisticsRouting = null;

  public function configure() {
    
    // Register listeners for Deal events
    $prefix = "deal.event.";
    //$this->dispatcher->connect($prefix.'submit', array('DealListener', 'eventSubmit'));
    //$this->dispatcher->connect($prefix.'approve', array('DealListener', 'eventApprove'));
    //$this->dispatcher->connect($prefix.'deny', array('DealListener', 'eventDeny'));
    //$this->dispatcher->connect($prefix.'pause', array('DealListener', 'eventPause'));
    //$this->dispatcher->connect($prefix.'resume', array('DealListener', 'eventResume'));
    //$this->dispatcher->connect($prefix.'trash', array('DealListener', 'eventTrash'));

    $this->dispatcher->connect($prefix.'submit', array('DealListener', 'updateMongoDeal'));
    $this->dispatcher->connect($prefix.'approve', array('DealListener', 'updateMongoDeal'));
    $this->dispatcher->connect($prefix.'deny', array('DealListener', 'updateMongoDeal'));
    $this->dispatcher->connect($prefix.'pause', array('DealListener', 'updateMongoDeal'));
    $this->dispatcher->connect($prefix.'resume', array('DealListener', 'updateMongoDeal'));
    $this->dispatcher->connect($prefix.'trash', array('DealListener', 'updateMongoDeal'));

    $this->dispatcher->connect('deal.couponQuantityChanged', array('DealListener', 'updateMongoDeal'));
  }

  public function generateStatisticsUrl($name, $parameters = array())
  {
    return sfConfig::get('app_settings_url').$this->getStatisticsRouting()->generate($name, $parameters);
  }

  public function getStatisticsRouting()
  {
    if (!$this->aStatisticsRouting)
    {
      $this->aStatisticsRouting = new sfPatternRouting(new sfEventDispatcher());

      $config = new sfRoutingConfigHandler();
      $routes = $config->evaluate(array(sfConfig::get('sf_apps_dir').'/statistics/config/routing.yml'));

      $this->aStatisticsRouting->setRoutes($routes);
    }

    return $this->aStatisticsRouting;
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

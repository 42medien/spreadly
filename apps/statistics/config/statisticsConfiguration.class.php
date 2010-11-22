<?php

class statisticsConfiguration extends sfApplicationConfiguration
{
  protected $aStatisticsRouting = null;

  public function configure() {

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

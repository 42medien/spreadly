<?php

class configuratorConfiguration extends sfApplicationConfiguration
{
	protected $aPlatformRouting = null;
	
  public function configure() {
  	
  }
 
  public function generatePlatformUrl($name, $parameters = array())
  {
    return sfConfig::get('app_settings_url').$this->getPlatformRouting()->generate($name, $parameters);
  }
 
  public function getPlatformRouting()
  {
    if (!$this->aPlatformRouting)
    {
      $this->aPlatformRouting = new sfPatternRouting(new sfEventDispatcher());
 
      $config = new sfRoutingConfigHandler();
      $routes = $config->evaluate(array(sfConfig::get('sf_apps_dir').'/platform/config/routing.yml'));
 
      $this->aPlatformRouting->setRoutes($routes);
    }
 
    return $this->aPlatformRouting;
  }
  
}

<?php
include('config.inc.php');

/**
 * the JS swiss-knife
 *
 * @author Matthias Pfefferle
 */
class JavaScriptUtils {
  
  // constants
  private $url = null;
  private $host = null;
  
  /**
   * the construcor (as the name says)
   */
  public function __construct() {
    $this->detectUrl();
    $this->normalizeHost();
  }
	
	public function getHost() {
		return $this->host;
	}
  
  /**
   * muting the layer depending on the DomainSettings
   */
  public function getMute() {
    $domain_settings = $this->getDomainSettingsObject();
    
    if ($domain_settings && array_key_exists("mute", $domain_settings)) {
      return $domain_settings["mute"];
    }
    
    return 60;
  }
  
  /**
   * muting the layer depending on the DomainSettings
   */
  public function displayAd() {
    $domain_settings = $this->getDomainSettingsObject();
    
    if ($domain_settings && array_key_exists("disable_ads", $domain_settings) && $domain_settings["disable_ads"]) {
      return false;
    }
    
    return true;
  }
  
  private function getDomainSettingsObject() {
    $collection_object = $this->getMongoCon()->selectCollection(LikeSettings::MONGO_DATABASENAME, 'domain_settings');
    
    if ($collection_object) {
      return $collection_object->findOne(array("domain" => $this->host));
    }
    return null;
  }
	
	public function getHeight() {
		if ($this->host == "www.rhein-zeitung.de" ||
        $this->host == "web-red.rz.newsfactory.de") {
			return 205;
		}
		
		return 250;
	}
	
	public function getWidth() {
		if ($this->host == "www.rhein-zeitung.de" ||
        $this->host == "web-red.rz.newsfactory.de") {
			return 466;
		}
		
		return 255;
	}
  
  /**
   * returns a mongo instance
   *
   * @return Mongo|null
   */
  protected function getMongoCon() {
    // checks if mongo is running
    try {
      $mongo = new Mongo(LikeSettings::MONGO_HOSTNAME, array("timeout" => 5000));
      return $mongo;
    } catch (Exception $e) {
      error_log($e->getMessage());
      return null;
    }
  }
  
  protected function detectUrl() {
    if (isset($_GET['host']) && !empty($_GET['host'])) {
      $this->url = trim(urldecode($_GET['host']));
    } elseif(isset($_SERVER['HTTP_REFERER']) && !empty($_SERVER['HTTP_REFERER'])) {
      $this->url = trim(urldecode($_SERVER['HTTP_REFERER']));
    }
  }
  
  /**
   * normalize the url host
   */
  protected function normalizeHost() {
    if ($this->url) {
      if ($host = parse_url($this->url, PHP_URL_HOST)) {
        $this->host = $host;
      }
    }
  }
}
<?php
/**
 * abstract class to do some pseudo threading
 *
 * @author Matthias Pfefferle
 * @author Peter Schweizer
 * @author Christian Weyand
 * 
 */
abstract class Thread {

  // script path have to be set in the child-thread
  protected $aScriptPath = null;

  /**
   * the child have to implement the construct with all needed parameters
   * all parameters have to be strings
   *
   * @example public function __construct($pId = 0, $pUserName = "test")
   */
  abstract function __construct();

  /**
   * function to start a php script in a pseudo thread
   *
   * @param array $pParameters
   */
  public function startThread($pParameters = array()) {
    if (!$this->aScriptPath) {
      throw new ThreadException("No Script defined", ThreadException::NO_SCRIPT_DEFINED);
    }

    sfContext::getInstance()->getLogger()->debug("{".__Class__."} Thread started");

    $lParameters = null;
    
    //build array of params
    foreach ($pParameters as $lP) {
      if (is_object($lP) || is_array($lP)) {
        throw new ThreadException("Objects and arrays are unallowed parameters", ThreadException::ONLY_PRIMITIVES_ALLOWED);
      }
      $lParameters[] = $lP;
    }
   
    
    $lExecStr = sfConfig::get('app_settings_fcgi_pathtobatch')."/threads/".$this->aScriptPath;
    
    sfContext::getInstance()->getLogger()->debug("{".__Class__."} used URL: ". $lExecStr);
    
    
        
    try {
      $fcgi = new FCGI(sfConfig::get('app_settings_fcgi_host'),sfConfig::get('app_settings_fcgi_port'));
      // $lParams is tranformed to queryString and passed to fcgi 
      $fcgi->QueryIgnoreReturndata($lExecStr, $lParameters);
    }
    catch (Exception $e) {
      sfContext::getInstance()->getLogger()->debug("{".__Class__."} Exception: ". print_r($e, true));  
    }
    sfContext::getInstance()->getLogger()->debug("{".__Class__."} Thread ended... ");
  }
}
?>
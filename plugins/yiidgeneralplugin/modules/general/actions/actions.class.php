<?php
/**
 * tags
 *
 * @package    communipedia
 * @subpackage frontend-modules
 * @version    $Id$
 * @copyright  (c) 2009 ekaabo GmbH
 */
class generalActions extends sfActions {

  /**
   * Executes index action
   *
   */
  public function executeIndex() {
  }
  
  /**
   * Executes index action
   *
   */
  public function executeJs_log(sfWebRequest $pRequest) {
    $this->getResponse()->setContentType('application/json');  	
  }  
}

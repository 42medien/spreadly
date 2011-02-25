<?php

/**
 * landing actions.
 *
 * @package    yiid
 * @subpackage landing
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class landingActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
  	$this->getResponse()->setSlot('js_document_ready', $this->getPartial('landing/js_init_landing.js'));
    //$this->forward('default', 'module');
  }
}

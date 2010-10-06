<?php

/**
 * discovery actions.
 *
 * @package    yiid
 * @subpackage discovery
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class discoveryActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('default', 'module');
  }

  public function executeHostmeta() {
    $this->getResponse()->setContentType('application/xrd+xml');
    $this->setLayout(false);
  }

  public function executeOexchange() {
    $this->getResponse()->setContentType('application/xrd+xml');
    $this->setLayout(false);
  }
}

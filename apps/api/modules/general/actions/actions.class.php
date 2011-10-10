<?php

/**
 * general actions.
 *
 * @package    yiid
 * @subpackage general
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class generalActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeLee(sfWebRequest $request) {
    $this->setLayout(false);
    $this->getResponse()->setContentType('application/json');
    $this->getResponse()->setStatusCode(404);
  }
}

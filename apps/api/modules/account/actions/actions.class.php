<?php

/**
 * account actions.
 *
 * @package    yiid
 * @subpackage account
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class accountActions extends sfActions
{
  /**
   * Executes index action
   *
   * @param sfRequest $request A request object
   */
  public function executeCreate(sfWebRequest $request) {
    $this->getResponse()->setContentType('application/json');
    $this->setLayout(false);

    // first api only accepts posts
    if ($request->getMethod() != "POST") {
      $this->getResponse()->setStatusCode(405);
      return $this->renderPartial("wrong_method");
    }
  }
}
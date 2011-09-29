<?php

/**
 * deals actions.
 *
 * @package    yiid
 * @subpackage deals
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class dealsActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request) {
    $this->getResponse()->setContentType('application/json');
    $this->setLayout(false);
    // first api only accepts posts
    if ($request->getMethod() != "POST") {
      $this->getResponse()->setStatusCode(405);
      return $this->renderPartial("wrong_method");
    }

    $access_token = $request->getParameter("access_token");

    // check access token
    if (!$access_token) {
      $this->getResponse()->setStatusCode(401);
      return $this->renderPartial("authentication_error");
    }

    $user = Doctrine_Core::getTable('sfGuardUser')->createQuery('u')
      ->where('u.access_token = ?', $access_token)
      ->addWhere('u.is_active = ?', true)->fetchOne();

    // check access token
    if (!$user) {
      $this->getResponse()->setStatusCode(401);
      return $this->renderPartial("authentication_error");
    }

    // @todo check if user has a deal address
    if (!$user->getApiPriceLike() || !$user->getApiPriceMediaPenetration()) {
      $this->getResponse()->setStatusCode(403);
      return $this->renderPartial("setup_failure");
    }

    // @todo deal anlegen und verifizieren
  }
}

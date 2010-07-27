<?php
/**
 * landing actions.
 *
 * @author     Matthias Pfefferle
 * @package    yiid
 * @subpackage landing
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class landingActions extends sfActions {
  /**
   * Executes index action
   *
   * @param sfRequest $request A request object
   */
  public function executeIndex(sfWebRequest $request) {
    if ($this->getUser()->isAuthenticated()) {
      $this->redirect("@stream_hot");
    }

    $this->pAuthType = $request->getParameter("auth", "delegated");
    $this->pError = null;

    if ($this->getUser()->hasFlash("error")) {
      $this->pError = $this->getUser()->getFlash("error");
    }
  }
}

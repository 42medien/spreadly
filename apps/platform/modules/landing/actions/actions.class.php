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
    $this->getResponse()->setSlot('js_document_ready', $this->getPartial('landing/js_init_landing.js'));

    if ($this->getUser()->isAuthenticated()) {
      $this->redirect("@stream");
    }

    $this->pAuthType = $request->getParameter("auth", "delegated");
    $this->pError = null;

    if ($this->getUser()->hasFlash("error")) {
      $this->pError = $this->getUser()->getFlash("error");
    }

    if($request->isXmlHttpRequest()) {
      $this->setLayout(false);
      $this->getResponse()->setContentType('application/json');
      $this->getUser()->setFlash("error", "Login required", true);

      return $this->renderText(
        'AuthError.redirect('.
        json_encode(
          array(
            "path"  => sfConfig::get("app_settings_url")
          )
        )
        .");"
      );
    }
  }

  public function executeMagic(sfWebRequest $request) {

  }
}

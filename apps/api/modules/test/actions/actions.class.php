<?php

/**
 * test actions.
 *
 * @package    yiid
 * @subpackage test
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class testActions extends sfActions {
  public function preExecute() {
    if (sfConfig::get("sf_environment") == "prod") {
      $this->forward404();
    }
  }

  public function executePush_endpoint(sfWebRequest $request) {
    if ($request->getMethod() == sfWebRequest::GET &&
        $request->getParameter("hub_mode") == 'subscribe' &&
        $request->getParameter("hub_challenge", null)) {
      sfContext::getInstance()->getLogger()->info("{TestPushApi} subscribed to '".$request->getParameter("hub_topic")."'");
      $this->setLayout(false);
      return $this->renderText($request->getParameter("hub_challenge"));
    } elseif ($request->getMethod() == sfWebRequest::POST) {
      $updates = json_decode(file_get_contents("php://input"), true);
      sfContext::getInstance()->getLogger()->info("{TestPushApi} subscribed to '$updates'");
    } else {
      sfContext::getInstance()->getLogger()->err("{TestPushApi} ".print_r(file_get_contents("php://input"), true));
      $this->setLayout(false);
      return $this->renderText("geht net!");
    }
  }
}

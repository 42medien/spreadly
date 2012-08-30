<?php

/**
 * pseudo actions.
 *
 * @package    yiid
 * @subpackage pseudo
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class pseudoActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeCustom_code(sfWebRequest $request) {
    $this->getResponse()->setHttpHeader('Access-Control-Allow-Origin', '*');
    $this->getResponse()->setContentType('application/json');
    $this->setLayout(false);

    $identifier = trim($request->getParameter("for", null));

    // check identifier
    if (!$identifier) {
      $this->getResponse()->setStatusCode(405);
      return $this->renderPartial("error");
    }

    $identifier = "custom_code_".$identifier;
    $obj = PersistentVariableTable::getInstance()->findOneByName($identifier);

    // check if there are some codes in the db
    if (!$obj) {
      $this->getResponse()->setStatusCode(405);
      return $this->renderPartial("error");
    }

    $this->code = $obj->getValue();
    $obj->delete();
  }
}
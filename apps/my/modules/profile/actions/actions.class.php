<?php

/**
 * profile actions.
 *
 * @package    yiid
 * @subpackage profile
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class profileActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request) {
    $this->user = $this->getUser()->getUser();
  }

  public function executeFeed($request) {
    $id = $request->getParameter("id");

    $user = UserTable::retrieveByUsername($id);

    $this->forward404Unless($user);

    $this->activities = MongoManager::getDM()->getRepository('Documents\YiidActivity')->findLatestByUserId($user->getId());

    $this->user = $user;
    $this->setLayout("atom_layout");
  }
}

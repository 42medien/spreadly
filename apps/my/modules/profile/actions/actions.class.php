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

    $this->activities = MongoManager::getDM()->getRepository('Documents\YiidActivity')->findLatestDealsByUserId($this->user->getId());
  }

  public function executeAtom_feed($request) {
    $id = $request->getParameter("id");

    $user = UserTable::retrieveByUsername($id);

    $this->forward404Unless($user);

    $this->activities = MongoManager::getDM()->getRepository('Documents\YiidActivity')->findLatestByUserId($user->getId());

    $this->user = $user;
    $this->setLayout("atom_layout");
  }
  
  public function executeDelete_identity(sfWebRequest $request) {
    $id = $request->getParameter("id");
    
    $online_identity = OnlineIdentityTable::retrieveVerifiedById($this->getUser()->getId(), $id);
    
    if (!$online_identity) {
      $this->getUser()->setFlash("error", "you can't delete this online-identity, perhaps it is not yours");
      $this->redirect("profile/index");
    }
    
    try {
      $online_identity->delete();
    } catch (Exception $e) {
      $this->getUser()->setFlash("error", $e->getMessage());
      $this->redirect("profile/index");
    }
    
    $this->redirect("profile/index");
  }
}

<?php

/**
 * approve_deal actions.
 *
 * @package    yiid
 * @subpackage approve_deal
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class approve_dealActions extends sfActions {
   
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request) {
    $this->deals = DealTable::getInstance()->findSubmitted();
  }
  
  public function executeApprove(sfWebRequest $request) {
    $dealId = $request->getParameter("deal_id");
    $dealParams = $request->getParameter("deal");
    
    if(!$dealId) $dealId = $dealParams['id'];
    
    $this->deal = DealTable::getInstance()->find($dealId);
    $this->form = new ApproveDealForm($this->deal);
    
    if($request->isMethod(sfRequest::PUT)) {
      $this->form->bind($dealParams);

      if($this->form->isValid()) {
        $deal = $this->form->save();
        $deal->approve();
        $this->redirect('approve_deal/index');
      }
    }
  }
    
}

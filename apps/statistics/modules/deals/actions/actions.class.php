<?php

/**
 * deals actions.
 *
 * @package    yiid_stats
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
  	$this->getResponse()->setSlot('js_document_ready', $this->getPartial('deals/js_init_deals.js'));
  }

  public function executeProceed(sfWebRequest $request) {
  	$this->getResponse()->setContentType('application/json');
    $lParams = $request->getParameter('deal');
    $lParams['tos_accepted'] = false;
    $lParams['domain_profile_id'] = $lParams['DomainProfile']['id'];
    //var_dump($lParams);die();

    if($lParams['id']){
      $lDeal = DealTable::getInstance()->find($lParams['id']);
      $this->pForm = new DealForm($lDeal);
    } else {
      $this->pForm = new DealForm();
      //$this->pForm->setDefault('domain_profile_id', $lFirstDomain->getId());
    }
		//var_dump($lParams);die();
    $lDomainObject = DomainProfileTable::getInstance()->find($lParams['DomainProfile']['id']);
    $lDomainForm = new DomainProfileDealForm($lDomainObject);
    $this->pForm->embedForm('DomainProfile', $lDomainForm);

    $this->pForm->bind($lParams);
    if($this->pForm->isValid()) {
	    $lObject = $this->pForm->save();
	    $lReturn['html'] = $this->getComponent('deals', 'get_code_form', array('pDealId' => $lObject->getId()));
    } else {
        $lReturn['html'] = $this->getPartial('deals/create_deal_form', array('pForm' => $this->pForm));
    }

    return $this->renderText(json_encode($lReturn));
  }

  public function executeSave($request){
    $lParams = $request->getParameter('deal');
    //$lParams['_csrf_token'] = $request->getParameter('_csrf_token');
		$lParams['id'] = 6;

    if($lParams['id']){
      $lDeal = DealTable::getInstance()->find($lParams['id']);
      $this->pForm = new DealForm($lDeal);
    }
    $lDealArray = $lDeal->toArray();
    $lDealArray['id'] = $lParams['id'];
    $lDealArray['tos_accepted'] = (isset($lParams['tos_accepted']))?$lParams['tos_accepted']: null;
    $lDealArray['_csrf_token'] = $lParams['_csrf_token'];

    //array_merge($lDeal->toArray(), $lParams);
    unset($lDealArray['deal_status']);
    unset($lDealArray['deal_type']);
    unset($lDealArray['quantity_reached']);
    unset($lDealArray['created_at']);
    unset($lDealArray['updated_at']);

    $this->pForm->bind($lDealArray);
    if($this->pForm->isValid()) {
	    $lObject = $this->pForm->save();
	    $lReturn['html'] = 'yiha..geschafft';
    } else {
			/*
    	$lErrorString='';
      foreach ($this->pForm->getErrorSchema()->getErrors() as $lError) {
        $lErrorString = $lError->getMessage().'<br/>';
      }*/
      $lReturn['html'] = $this->getPartial('deals/get_code_form', array('pForm' => $this->pForm));
      $lReturn['getdealcode'] = $request->getParameter('getdealcode');
    }
    return $this->renderText(json_encode($lReturn));
  }
}

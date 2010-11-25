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

 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeTesterle(sfWebRequest $request) {
  	$this->getResponse()->setSlot('js_document_ready', $this->getPartial('deals/js_init_deals.js'));
    //$lDealForm = new DealForm();
    $lDomainForm = new DomainProfileDealForm();

    //$lDomainForm->embedForm('deal', $lDealForm);
    $this->pForm = $lDomainForm;

  }

  public function executeTesterle_save(sfWebRequest $request) {
    //var_dump($request->getPostParameters());exit;

  	$lParams = $request->getPostParameters();

    $lParams['new']['domain_profile_id'] = $lParams['id'];

    //$lDealForm = new DealForm();
    $lDomainObject = DomainProfileTable::getInstance()->find($lParams['id']);
    $lDomainForm = new DomainProfileDealForm($lDomainObject);

    //$lDomainForm->embedForm('deal', $lDealForm);

  	$lDomainForm->bind($lParams);
    if($lDomainForm->isValid()) {
	    $lObject = $lDomainForm->save();
	    var_dump($lObject);die();
    } else {
    	$lErrorString='';
      foreach ($lDomainForm->getErrorSchema()->getErrors() as $lError) {
        $lErrorString = $lError->getMessage().'<br/>';
      }
        var_dump($lErrorString);die();

    }

  }

  public function executeProceed(sfWebRequest $request) {
  	$this->getResponse()->setContentType('application/json');
  	$lParams = $request->getPostParameters();

    $lParams['deal']['domain_profile_id'] = $lParams['id'];
		unset($lParams['ei_kcuf']);
    //$lDealForm = new DealForm();


    if($lDealId = $lParams['deal']['id']){
      $lDeal = DealTable::getInstance()->find($lDealId);
      $lDealForm = new DealForm($lDeal);
    } else {
      $lDealForm = new DealForm();
      $lDealForm->setDefault('domain_profile_id', $lParams['id']);
    }

    $lDomainObject = DomainProfileTable::getInstance()->find($lParams['id']);
    $this->pForm = new DomainProfileDealForm($lDomainObject);
    $this->pForm->embedForm('deal', $lDealForm);

    $this->pForm->bind($lParams);
    if($this->pForm->isValid()) {
	    $lObject = $this->pForm->save();
	    $lReturn['html'] = 'affe';
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

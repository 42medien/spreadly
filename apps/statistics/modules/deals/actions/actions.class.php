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
  	$this->pDeals = DealTable::getInstance()->findBy('sf_guard_user_id', $this->getUser()->getUserId());
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

  public function executeSave(sfWebRequest $request) {
  	$this->getResponse()->setContentType('application/json');
  	$lParams = $request->getPostParameters();

    $lParams['deal']['domain_profile_id'] = $lParams['id'];
    $lParams['deal']['sf_guard_user_id'] = $this->getUser()->getUserId();
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
    $lDealForm->embedForm('coupon', new CouponCodesForm());
    $this->pForm->embedForm('deal', $lDealForm);

    $this->pForm->bind($lParams);
    if($this->pForm->isValid()) {
	    $lObject = $this->pForm->save();
	    $deal = $this->pForm->getEmbeddedForm('deal')->getObject();
	    $deal->saveCoupons($values['deal']['coupon']);
	    $lReturn['html'] = $this->getPartial('deals/deal_in_process');
    } else {
    	$lReturn['html'] = $this->getPartial('deals/create_deal_form', array('pForm' => $this->pForm));
    }

    return $this->renderText(json_encode($lReturn));
  }

  public function executeGet_create_form(sfWebRequest $request) {
  	$this->getResponse()->setContentType('application/json');
  	$lDealId = $request->getParameter('deal_id', null);
    return $this->renderText(json_encode(
    	array(
    		'html' => $this->getComponent('deals', 'create_deal_form', array('pDealId' => $lDealId)),
    		'initform' => true
    	)
    ));
  }

  public function executeGet_create_index(sfWebRequest $request) {
  	$this->getResponse()->setContentType('application/json');
    return $this->renderText(json_encode(
    	array(
    		'html' => $this->getPartial('deals/create_index')
    	)
    ));
  }

  public function executeGet_domain_profile(sfWebRequest $request) {
  	$this->getResponse()->setContentType('application/json');
  	$lProfileId = $request->getParameter('dpid');
    $lDp = DomainProfileTable::getInstance()->find($lProfileId);
    //if u need much more from the object return a ldp->toarray jsonfied to the js
    $lReturn['imprint_url'] = $lDp->getImprintUrl();

    return $this->renderText(json_encode($lReturn));
  }

  public function executeEdit_enddate(sfWebRequest $request) {
  	$this->getResponse()->setContentType('application/json');
    return $this->renderText(json_encode(
    	array(
    		'success' => true,
    	  'content' => 'content'
    	)
    ));
  }

  public function executeSave_codes(sfWebRequest $request){
  	$this->getResponse()->setContentType('application/json');
  	$params = $request->getPostParameters();
  	$deal = DealTable::getInstance()->find($params['deal_id']);
    $deal->addCoupons($params);

    return $this->renderText(json_encode(
    	array(
    		'success' => true,
    	  'content' => $deal->getCouponQuantity()
    	)
    ));
  }

  public function executeSave_quantity(sfWebRequest $request){
  	$this->getResponse()->setContentType('application/json');
  	$params = $request->getPostParameters();
  	$deal = DealTable::getInstance()->find($params['deal_id']);
    $error = "";
  	if($numeric=is_numeric($params['quantity']) && $higher=$params['quantity']>$deal->getCouponQuantity()) {
      $deal->setCouponQuantity($params['quantity']);
      $deal->addCoupons($params);
  	} else {
  	  $error = $numeric ? '' : 'not a number';
  	  $error.((!$numeric&&!$higher) ? ' and ' : '');
  	  $error.($higher ? '' : 'not more than before');
  	}

    return $this->renderText(json_encode(
    	array(
    		'success' => empty($error),
    		'error' => empty($error) ? '' : $error,
    	  'content' => $deal->getCouponQuantity()
    	)
    ));
  }

  public function executePaste_codes(sfWebRequest $request){
		$lDealId = $request->getParameter('deal_id');
		$this->pDealId = $lDealId;
  }
}

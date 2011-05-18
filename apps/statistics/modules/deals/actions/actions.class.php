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
  	$lQuery = DealTable::getInstance()->createQuery()->where('sf_guard_user_id = ?', $this->getUser()->getUserId())->orderBy("created_at DESC");
  	$this->pDeals = $lQuery->execute();
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

  public function executeGet_tags(sfWebRequest $request) {
  	$this->getResponse()->setContentType('application/json');
  	$lArray =  array("Affe", "Pferd", "Pinguin");
    return $this->renderText(json_encode($lArray));
  }

  private function getCleanedParams($pRequest) {
    $lParams = $pRequest->getPostParameters();
    $lParams['deal']['domain_profile_id'] = $lParams['id'];
    $lParams['deal']['sf_guard_user_id'] = $this->getUser()->getUserId();
		unset($lParams['ei_kcuf']);
		unset($lParams['single-quantity']);

    // Cleaning up the single code/multi code dilemma
    ($lParams['deal']['coupon_type']=='single' || $lParams['deal']['coupon_type']=='url') ? $lParams['deal']['coupon']['multiple_codes']="" : $lParams['deal']['coupon']['single_code']="";
    $lParams['deal']['tags'] = ($lParams['deal']['addtags'] == 'addnotags')? $lParams['deal']['tags'] = NULL: $lParams['deal']['tags'];

    return $lParams;
  }

  private function getFormWithEmbeddedForms($pDomainProfileId, $pDealForm, $pDeal, $pParams) {
    $lDomainObject = DomainProfileTable::getInstance()->find($pDomainProfileId);
    $lForm = new DomainProfileDealForm($lDomainObject);
    $lCouponForm = new CouponCodesForm();
    $lI18n = sfContext::getInstance()->getI18N();

    if($pDeal==null || $pDeal->isNew()) {
      $lCouponForm->getValidatorSchema()->setPostValidator(
        new sfValidatorOr(array(
          new sfValidatorSchemaFilter('single_code', new sfValidatorString(array('required' => true), array('required' => $lI18n->__('Required')))),
          new sfValidatorSchemaFilter('multiple_codes', new sfValidatorString(array('required' => true), array('required' => $lI18n->__('Required'))))
        ))
      );
    }

    if($pParams['deal']['coupon_type']=='url'){
      $lCouponForm->getValidatorSchema()->setPostValidator(
          new sfValidatorSchemaFilter('single_code', new sfValidatorUrl(array('required' => true), array('required' => $lI18n->__('no url'))))
      );
    }

    $pDealForm->embedForm('coupon', $lCouponForm);
    $lForm->embedForm('deal', $pDealForm);
    return $lForm;
  }

  public function executeSave(sfWebRequest $request) {
  	$this->getResponse()->setContentType('application/json');
  	$lParams = $this->getCleanedParams($request);

    $lAddTags = $lParams['deal']['addtags'];

    $lDeal=null;
    if($lDealId = $lParams['deal']['id']){
      $lDeal = DealTable::getInstance()->find($lDealId);
      $lDealForm = new DealForm($lDeal);
    } else {
      $lDealForm = new DealForm();
      $lDealForm->setDefault('domain_profile_id', $lParams['id']);
    }

    $this->pForm = $this->getFormWithEmbeddedForms($lParams['id'], $lDealForm, $lDeal, $lParams);

    $this->pForm->bind($lParams);

    if($this->pForm->isValid()) {
	    $lObject = $this->pForm->save();
	    $lDealFromForm = $this->pForm->getEmbeddedForm('deal')->getObject();

	    if($lDeal) {
  	    $lDealFromForm->addMoreCoupons($lParams['deal']['coupon']);
	      $lIsNew = false;
	    } else {
  	    $lDealFromForm->saveInitialCoupons($lParams['deal']['coupon']);
  	    $lIsNew = true;
	    }

      $lDealFromForm->submit();

	    $lReturn['html'] = $this->getPartial('deals/deal_in_process', array('pIsNew' => $lIsNew));
    } else {
    	$lCouponType = $lParams['deal']['coupon_type'];
    	$lCouponQuantity = isset($lParams['deal']['coupon_quantity']) ? $lParams['deal']['coupon_quantity'] : 0;

    	$lTaintedValues = $this->pForm->getTaintedValues();
    	$lDefaultCode = 'Coupon Code';
    	if($lParams['deal']['coupon_type'] == 'single'){
    		$lDefaultCode = $lTaintedValues['deal']['coupon']['single_code'];
    	}

    	$lReturn['html'] = $this->getPartial('deals/create_deal_form', array('pForm' => $this->pForm, 'pCouponType' => $lCouponType, 'pCouponQuantity' => $lCouponQuantity, 'pDefaultCode' => $lDefaultCode, 'pAddtags' => $lAddTags));
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

  public function executeGet_form_by_domain(sfWebRequest $request) {
  	$this->getResponse()->setContentType('application/json');
    $lI18n = sfContext::getInstance()->getI18N();
  	$lProfileId = $request->getParameter('dpid');
    $lDp = DomainProfileTable::getInstance()->find($lProfileId);
    $lDealForm = new DealForm();
    $lFirstDomain = DomainProfileTable::getInstance()->find($lProfileId);
    $lAddtags = 'addnotags';
  	$lCouponType = 'single';
  	$lCouponQuantity = '0';
    $this->pEdited = false;
    $lDealForm->setDefaults(array(
				'button_wording' => $lI18n->__('...and win a free trial membership!'),
				'summary' => $lI18n->__('Free trial membership'),
				'description' => $lI18n->__('Like and win a free one month trial membership'),
	    	'terms_of_deal' => 'Url to Conditions of Participation',
	    	'start_date' => date('Y-m-d G:i:s'),
	    	'end_date' => date('Y-m-d G:i:s'),
	    	'coupon_type' => 'single',
    	  'redeem_url' => '',
	      'addtags' => $lAddtags,
	  ));

    $this->pForm = new DomainProfileDealForm();
    $this->pForm->setDefaults(array(
			'id' => $lFirstDomain->getId()
    ));

    $lDealForm->embedForm('coupon', new CouponCodesForm());
    $this->pForm->embedForm('deal', $lDealForm);

    return $this->renderText(json_encode(
    	array(
    		'html' => $this->getPartial('deals/create_deal_form', array('pForm' => $this->pForm, 'pCouponQuantity' => $lCouponQuantity, 'pCouponType' => $lCouponType, 	'pDefaultCode' => 'JSFDJKAREWRKOP', 'pAddtags' => $lAddtags)),
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

    return $this->renderText(json_encode($lReturn));
  }

  public function executeEdit_enddate(sfWebRequest $pRequest) {
  	$this->getResponse()->setContentType('application/json');
  	$lParams = $pRequest->getPostParameters();
  	$lDeal = DealTable::getInstance()->find($lParams['id']);

    if($this->getUser()->isMine($lDeal)) {
  	  $lValid = $lDeal->validateNewEndDate($lParams['input']);

      if($lValid===true) {
        $lDeal->save();
      }
    } else {
      $lValid = "You are not allowed to do this.";
    }
    return $this->renderText(json_encode(
    	array(
    		'success' => $lValid===true,
    		'error' => $lValid===true ? '' : $lValid,
    	  'html' => $this->getPartial('deals/deal_table_row', array('pDeal' => $lDeal)),
    	  'cssid' => 'deal-table-row-'.$lDeal->getId()
    	)
    ));
  }

  public function executeSave_codes(sfWebRequest $pRequest){
  	$this->getResponse()->setContentType('application/json');
  	$lParams = $pRequest->getPostParameters();
  	$lDeal = DealTable::getInstance()->find($lParams['deal_id']);
  	$lError = '';
    if($this->getUser()->isMine($lDeal) && $lDeal->getCouponType()==DealTable::COUPON_TYPE_MULTIPLE) {
      $lDeal->addMoreCoupons(array('multiple_codes' => $lParams['multiple_codes']));
    } else {
      $lError = "You can not add codes to coupons of type single.";
    }

    return $this->renderText(json_encode(
    	array(
    		'success' => empty($lError),
    		'error' => empty($lError) ? '' : $lError,
    	  'html' => $this->getPartial('deals/deal_table_row', array('pDeal' => $lDeal)),
    	  'cssid' => 'deal-table-row-'.$lDeal->getId()
    	)
    ));
  }

  public function executeSave_quantity(sfWebRequest $pRequest){
  	$this->getResponse()->setContentType('application/json');
  	$lParams = $pRequest->getPostParameters();
  	$lParams['input'] = trim($lParams['input']);
  	$lDeal = DealTable::getInstance()->find($lParams['deal_id']);

    if($this->getUser()->isMine($lDeal)) {
      $lValid = $lDeal->validateNewQuantity($lParams['input']);

      if($lValid===true) {
        $lDeal->addMoreCoupons(array('quantity' => $lParams['input']-$lDeal->getCouponQuantity()));
      }
    } else {
      $lValid = "You are not allowed to do this.";
    }


    return $this->renderText(json_encode(
    	array(
    		'success' => $lValid===true,
    		'error' => $lValid===true ? '' : $lValid,
    	  'html' => $this->getPartial('deals/deal_table_row', array('pDeal' => $lDeal)),
    	  'cssid' => 'deal-table-row-'.$lDeal->getId()
    	)
    ));
  }

  public function executePaste_codes(sfWebRequest $request){
		$lDealId = $request->getParameter('deal_id');
		$this->pDealId = $lDealId;
  }

  public function executeSet_state(sfWebRequest $request) {
  	$this->getResponse()->setContentType('application/json');
  	$lParams = $request->getGetParameters();
  	$lDeal = DealTable::getInstance()->find($lParams['deal_id']);
  	$lPrevState = $lDeal->getState();
  	$lError = "";
  	if($lDeal->canTransitionTo($lParams['state'])) {
    	$lDeal->transitionTo($lParams['state']);
  	} else {
  	  $lError = "Cannot transition to: ".$lParams['state'];
  	}
  	return $this->renderText(json_encode(
    	array(
    		'success' => empty($lError),
    		'error' => $lError,
    		'html' => $this->getPartial('deals/deal_table_row_content', array('pDeal' => $lDeal)),
    	  'state' => $lPrevState,
    	  'classes' => $lDeal->getCssClasses()
    	)
    ));
  }

  public function executeGet_deal_table(sfWebRequest $request){
  	$this->getResponse()->setContentType('application/json');
  	$lQuery = DealTable::getInstance()->createQuery()->where('sf_guard_user_id = ?', $this->getUser()->getUserId())->orderBy("created_at DESC");
  	$lDeals = $lQuery->execute();

  	return $this->renderText(json_encode(
    	array(
    		'success' => empty($lError),
    		'html' => $this->getPartial('deals/deal_table', array('pDeals' => $lDeals)),
    	)
    ));
  }
}

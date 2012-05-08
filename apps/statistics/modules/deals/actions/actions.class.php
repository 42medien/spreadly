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
  	//$this->getResponse()->setSlot('js_document_ready', $this->getPartial('deals/js_init_deals.js'));
  	$lQuery = DealTable::getInstance()->createQuery()->where('sf_guard_user_id = ?', $this->getUser()->getUserId())->orderBy("created_at DESC");
  	$this->pDeals = $lQuery->execute();
  }

  /**
   * check, if the user is allowed to edit the deals or call the step...
   * inits the deal-form
   * @see sfAction::preExecute()
   */
  public function preExecute() {
    $request = $this->getRequest();
    $this->pDealId = $request->getParameter('did', null);
    $this->pDeal = new Deal();
		$this->pForm = new CreateDealForm($this->pDeal);
  	$this->pDomainProfiles = $this->getUser()->getVerifiedDomainsWidthId();
		$this->pForm->getWidget('domain_profile_id')->setOption('choices', $this->pDomainProfiles);

		//check, if there is a deal
		if($this->pDealId) {
			$this->pDeal = DealTable::getInstance()->find($this->pDealId);

			if(!$this->pDeal){
				$this->redirect404();
			}

			//is user allowed to edit the deal?
			if($this->getUser()->getUserId() != $this->pDeal->getSfGuardUserId()){
				$this->redirect404();
			}
			//if he is allowed, create a deal-form with the deal-object
			$this->pForm = new CreateDealForm($this->pDeal);
			$this->pForm->getWidget('domain_profile_id')->setOption('choices', $this->pDomainProfiles);
  		$this->pForm->setDefault('domain_profile_id', $this->pDeal->getDomainProfileId());
		} else {
			//every create deal action needs the deal-id as get param except step_campaign
			if($this->actionName != 'step_campaign') {
				$this->redirect404();
			}
		}
  }


  /**
   * Create deal - step 1: Give the deal a name and select the target quantity
   * @param sfWebRequest $request
   * @todo statemachine-moped einbauen
   */
  public function executeStep_campaign(sfWebRequest $request){
  	$this->getResponse()->setSlot('js_document_ready', $this->getPartial('deals/js_init_deals.js'));

  	$this->pForm->validate_campaign();

  	if($request->getMethod() == 'POST'){
  		$lParams = $request->getPostParameters();
  		$lParams['sf_guard_user_id'] = $this->getUser()->getUserId();

  		$this->pForm->bind($lParams);
  		if($this->pForm->isValid()){
	  		if($lParams['billing_type'] == 'media_penetration') {
	  			$lParams['target_quantity'] = $lParams['target_quantity_mp'];
	  		}
	  		unset($lParams['target-quantity-type']);
	  		$this->pForm->bind($lParams);
  			$lDeal = $this->pForm->save();

  			$prices = sfConfig::get("app_deal_pricing_".$lDeal->getBillingType());
  			$lDeal->setPrice($prices[$lDeal->getTargetQuantity()]);
  			$lDeal->save();

  			if($lParams['type'] == 'tags') {
  				$lTags = explode(',',$lParams['tags']);
  				$lDeal->addTag($lTags);
  				$lDeal->save();
  			}

  			$lDeal->complete_campaign();
	 			$this->redirect('deals/step_share?did='.$lDeal->getId());
  		}
  	} else if($this->pDeal->canReset_to_campaign()) {
  	  $this->pDeal->reset_to_campaign();
  	} else if($this->pDeal->getState() != DealTable::STATE_INITIAL) {
  	  $this->redirect404();
  	}
  }

  /**
   * Create deal - step 2: design the motivation and the share, that will be send to the networks
   * @param sfWebRequest $request
   */
  public function executeStep_share(sfWebRequest $request) {
  	$this->getResponse()->setSlot('js_document_ready', $this->getPartial('deals/js_init_deals.js'));
  	$this->pForm->validate_share();
   	if($request->getMethod() == 'POST'){
  		$lParams = $request->getPostParameters();
  		$this->pForm->bind($lParams);
  		if($this->pForm->isValid()){
  			$lDeal = $this->pForm->save();
  			$lDeal->complete_share();
	 			$this->redirect('deals/step_coupon?did='.$lDeal->getId());
  		}
  	} else if($this->pDeal->canReset_to_share()) {
  	  $this->pDeal->reset_to_share();
  	} else if($this->pDeal->getState() != DealTable::STATE_CAMPAIGN_COMPLETED) {
  	  $this->redirect404();
  	}
  }

  /**
   * Create deal - step 3: design the coupon, that the user will see after the deal like
   * @param sfWebRequest $request
   */
  public function executeStep_coupon(sfWebRequest $request) {
  	$this->getResponse()->setSlot('js_document_ready', $this->getPartial('deals/js_init_deals.js'));
  	$this->pForm->validate_coupon();
   	if($request->getMethod() == 'POST'){
  		$lParams = $request->getPostParameters();
  		$this->pForm->bind($lParams);
  		if($this->pForm->isValid()){
  			$lDeal = $this->pForm->save();
  			$lDeal->complete_coupon();
	 			$this->redirect('deals/step_billing?did='.$lDeal->getId());
  		}
  	} else if($this->pDeal->canReset_to_coupon()) {
  	  $this->pDeal->reset_to_coupon();
  	} else if($this->pDeal->getState() != DealTable::STATE_SHARE_COMPLETED) {
  	  $this->redirect404();
  	}
  }

  /**
   * Create deal - step 4: select the payment method and insert address
   * @param sfWebRequest $request
   */
  public function executeStep_billing(sfWebRequest $request){
  	$this->getResponse()->setSlot('js_document_ready', $this->getPartial('deals/js_init_deals.js'));
  	//$this->pForm->validate_billing();
  	$this->pPaymentMethods = $this->getUser()->getGuardUser()->getPaymentMethods();
  	$this->pPaymentMethodForm = new PaymentMethodForm();

    //$lPaymentMethodForm = new PaymentMethodForm();
    //$this->pForm->embedForm('payment_method', $lPaymentMethodForm);
  	if($request->getMethod() == 'POST'){
  		$lParams = $request->getPostParameters();
  		$lIsNew = true;
  		$lParams['sf_guard_user_id'] = $this->getUser()->getUserId();

  		//check if the user selected an old address or if he inserted a new
  		//if he selected an old, overwrite the form-values with the database-data -> needet for validation
  		if(isset($lParams['existing_pm_id']) && $lParams['existing_pm_id'] != 'false'){
  			//find the selected pm object
				$lSelectedPM = PaymentMethodTable::getInstance()->find($lParams['existing_pm_id']);
				//fill the values for validation
				$lParams['company'] = $lSelectedPM->getCompany();
				$lParams['contact_name'] = $lSelectedPM->getContactName();
				$lParams['address'] = $lSelectedPM->getAddress();
				$lParams['zip'] = $lSelectedPM->getZip();
				$lParams['city'] = $lSelectedPM->getCity();
				//$lParams['payment_method_id'] = $lParams['existing_pm_id'];
				//bind the object to the form -> needed for update (if you don't do this, symfony always inserts a new db entry)
    		$this->pPaymentMethodForm = new PaymentMethodForm($lSelectedPM);
    		//$this->pForm->embedForm('payment_method', $lPaymentMethodForm);
  		}

  		//unset the param, that check, if user selected an existent payment method
  		unset($lParams['existing_pm_id']);
			//var_dump($lParams);die();
			//var_dump($lParams);die();
  		//bind and validatevalidate
  		//unset($lParams['payment_method_id']);

  		$this->pPaymentMethodForm->bind($lParams);
  		//var_dump($this->pPaymentMethodForm->isValid());die();
  		if($this->pPaymentMethodForm->isValid()){
  			//aus irgendnem beschissenen grund setzt doctrine oder symfony oder was auch immer die pm-id nicht im deal beim speichern des formulars, deswegen alles nochmal schön brav per hand...doh...wenn jemand da schlauer ist, soll ers gerne alles ändern....vallah
  			$lPm = $this->pPaymentMethodForm->save();
				//$lPm = $this->pForm->getEmbeddedForm('payment_method')->getObject();
				$this->pDeal->setPaymentMethodId($lPm->getId());
 				$this->pDeal->save();
  			$this->pDeal->complete_billing();
	 			$this->redirect('deals/step_verify?did='.$this->pDeal->getId());
  		}
  	} else if($this->pDeal->canReset_to_billing()) {
  	  $this->pDeal->reset_to_billing();
  	} else if($this->pDeal->getState() != DealTable::STATE_COUPON_COMPLETED) {
  	  $this->redirect404();
  	}
  }

  /**
   * Create deal - step 5: have a last look at your inserts and send deal to approvement
   * @param sfWebRequest $request
   */
  public function executeStep_verify(sfWebRequest $request){
  	$this->pForm->validate_verify();
    if($request->getMethod() == 'POST'){
  		$lParams = $request->getPostParameters();
  		unset($lParams['area-like-comment']);
  		unset($lParams['twitter']);
  		unset($lParams['facebook']);
  		unset($lParams['linkedin']);
  		unset($lParams['google']);
  		$this->pForm->bind($lParams);
  		if($this->pForm->isValid()){
  			$lDeal = $this->pForm->save();
	  	  $lDeal->submit();
	  	  $this->redirect('deals/step_submitted?did='.$this->pDeal->getId());
  		}
  	}/* elseif($this->pDeal->getState() != DealTable::STATE_BILLING_COMPLETED) {
  	  $this->redirect404();
  	}*/
  }


  /**
   *
   * success side after submitting deal
   * @param sfWebRequest $request
   */
  public function executeStep_submitted(sfWebRequest $request){}

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

    if($lParams['single-quantity'] == 'unlimited'){
    	unset($lParams['deal']['coupon_quantity']);
    }
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
    $lFirstDomain = DomainProfileTable::getInstance()->find($lParams['id']);
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
    	if($lParams['deal']['coupon_type'] == 'single' || $lParams['deal']['coupon_type'] == 'url'){
    		$lDefaultCode = $lTaintedValues['deal']['coupon']['single_code'];
    	}
    	$lReturn['coupontype'] = $lParams['deal']['coupon_type'];
    	$lReturn['html'] = $this->getPartial('deals/create_deal_form', array('pFirstDomain'=> $lFirstDomain, 'pForm' => $this->pForm, 'pCouponType' => $lCouponType, 'pCouponQuantity' => $lCouponQuantity, 'pDefaultCode' => $lDefaultCode, 'pAddtags' => $lAddTags));
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

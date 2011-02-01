<?php

class dealsComponents extends sfComponents {

  public function executeCreate_deal_form(sfWebRequest $request) {
    $lI18n = sfContext::getInstance()->getI18N();
    $lDealId = $this->pDealId;
    $lDeal = null;

    if($lDealId){
      $lDeal = DealTable::getInstance()->find($lDealId);
      $lDealForm = new DealForm($lDeal);
      $lFirstDomain = DomainProfileTable::getInstance()->find($lDeal->getDomainProfileId());
    } else {
      $lDealForm = new DealForm();
	    $lVerifiedDomains = DomainProfileTable::retrieveVerifiedForUser($this->getUser()->getGuardUser());
    	$lFirstDomain = $lVerifiedDomains[1];
    }
    $this->pAddtags = 'addnotags';

    if($lDeal) {
    	$this->pCouponType = $lDeal->getCouponType();
    	$this->pCouponQuantity = $lDeal->getCouponQuantity();

    	$this->pTags = $lDeal->getTags();
    	if($this->pTags != null && $this->pTags != ''){
    		$this->pAddtags = 'addtags';
    	}

      $this->pDeal = $lDeal;
    	$lDealForm->setDefaults(array(
    	  'id' => $lDeal->getId(),
				'terms_of_deal' => $lDeal->getTermsOfDeal(),
				'button_wording' => $lDeal->getButtonWording(),
				'summary' => $lDeal->getSummary(),
				'description' => $lDeal->getDescription(),
    	  'terms_of_deal' => $lDeal->getTermsOfDeal(),
	    	'start_date' => $lDeal->getStartDate(),
	    	'end_date' => $lDeal->getEndDate(),
    		'coupon_quantity' => $lDeal->getCouponQuantity(),
        'coupon_type' => $this->pCouponType,
    	  'redeem_url' => $lDeal->getRedeemUrl(),
    	  'tos_accepted' => $lDeal->getTosAccepted(),
	      'addtags' => $this->pAddtags,
    		'tags' => $this->pTags
      ));

      $lCoupons = $lDeal->getCoupons();
      if(count($lCoupons) > 0){
 				$this->pDefaultCode = $lCoupons[0]->getCode();
      } else {
      	$this->pDefaultCode = $lI18n->__('Coupon Code');
      }

    } else {
    	$this->pCouponType = 'single';
    	$this->pCouponQuantity = '0';
      $this->pEdited = false;
	    $lDealForm->setDefaults(array(
				'button_wording' => $lI18n->__('...and win a free trial membership!'),
				'summary' => $lI18n->__('Free trial membership'),
				'description' => $lI18n->__('Like and win a free one month trial membership'),
	    	'terms_of_deal' => $lI18n->__('Url to Conditions of Participation'),
	    	'start_date' => date('Y-m-d G:i:s'),
	    	'end_date' => date('Y-m-d G:i:s'),
	    	'coupon_type' => 'single',
	      'addtags' => 'addnotags',
    	  'redeem_url' => $lI18n->__('Your redeem url')
	    ));
	    $this->pDefaultCode = 'Coupon Code';
    }
    $this->pForm = new DomainProfileDealForm();
    $this->pForm->setDefaults(array(
			'id' => $lFirstDomain->getId()
    ));


    $lCouponForm = new CouponCodesForm();
    $lCouponForm->setDefaults(array(
    		'single_code' => $this->pDefaultCode
	    )
    );

    $lDealForm->embedForm('coupon', $lCouponForm);
    //if single: getcode, if multiple: getcodes
    $this->pForm->embedForm('deal', $lDealForm);
  }

  public function executeGet_code_form($request) {
    $lDealId = $this->pDealId;

    $lDeal = DealTable::getInstance()->find($lDealId);
    $this->pForm = new DealForm($lDeal);
  }
}
?>
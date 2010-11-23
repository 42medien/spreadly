<?php

class dealsComponents extends sfComponents {

  public function executeCreate_deal_form(sfWebRequest $request) {
    $lI18n = sfContext::getInstance()->getI18N();
    $lDealId = $request->getParameter('deal_id', null);
    $lDeal = '';

    if($lDealId){
      $lDeal = DealTable::getInstance()->find($lDealId);
      $this->pForm = new DealForm($lDeal);
    } else {
      $this->pForm = new DealForm();
      //$this->pForm->setDefault('domain_profile_id', $lFirstDomain->getId());
    }

    /*

    $lVerifiedDomains = DomainProfileTable::retrieveVerifiedForUser($this->getUser()->getGuardUser());
    $lFirstDomain = $lVerifiedDomains[0];*/
    //$lDomainForm->setDefault('id', $lFirstDomain->getId());
    $lDomainForm = new DomainProfileDealForm();
    $this->pForm->embedForm('DomainProfile', $lDomainForm);

    if($lDeal) {
      $this->pForm->setDefaults(array(
				'terms_of_deal' => $lDeal->getTermsOfDeal(),
				'button_wording' => $lDeal->getButtonWording(),
				'summary' => $lDeal->getSummary(),
				'description' => $lDeal->getDescription(),
	    	'start_date' => $lDeal->getStartDate(),
	    	'end_date' => $lDeal->getEndDate()
      ));
    } else {
	    $this->pForm->setDefaults(array(
				'button_wording' => $lI18n->__('...und freien Probemonat gewinnen!'),
				'summary' => $lI18n->__('Kostenloser Probemonat'),
				'description' => $lI18n->__('Liken und damit einmalig pro Person einen freien Probemonat gewinnen!'),
	    	'start_date' => date('Y-m-d G-i-s'),
	    	'end_date' => date('Y-m-d G-i-s')
	    ));
    }
  }

  public function executeGet_code_form($request) {
    $lDealId = $this->pDealId;

    $lDeal = DealTable::getInstance()->find($lDealId);
    $this->pForm = new DealForm($lDeal);
  }
}
?>
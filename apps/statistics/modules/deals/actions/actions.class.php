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

  public function executeCreate(sfWebRequest $request) {
  	$this->getResponse()->setContentType('application/json');
    $lParams = $request->getParameter('deal');

    if($lParams['id']){
      $lDeal = DealTable::getInstance()->find($lParams['id']);
      $this->pForm = new DealForm($lDeal);
    } else {
      $this->pForm = new DealForm();
      //$this->pForm->setDefault('domain_profile_id', $lFirstDomain->getId());
    }

    $lDomainObject = DomainProfileTable::getInstance()->find($lParams['DomainProfile']['id']);
    $lDomainForm = new DomainProfileDealForm($lDomainObject);
    $this->pForm->embedForm('DomainProfile', $lDomainForm);

    $this->pForm->bind($lParams);
    if($this->pForm->isValid()) {
	    $lObject = $this->pForm->save();
	     	$lReturn['html'] = $this->getPartial('deals/get_code_form', array('pForm' => $this->pForm));
    } else {
        $lReturn['html'] = $this->getPartial('deals/create_deal_form', array('pForm' => $this->pForm));
    }
    $this->setTemplate('index', 'deals');
  }

  public function executeCreate_deal_form(sfWebRequest $request) {

  }
}

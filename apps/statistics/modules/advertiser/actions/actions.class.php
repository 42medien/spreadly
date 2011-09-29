<?php

/**
 * advertiser actions.
 *
 * @package    yiid
 * @subpackage advertiser
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class advertiserActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
  }

  public function executeApply_api(sfWebRequest $request){
  	$this->pUser = $this->getUser()->getGuardUser();
  	$this->pPaymentMethods = $this->getUser()->getGuardUser()->getPaymentMethods();
  	$this->pPaymentMethodForm = new PaymentMethodForm();

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
  		}

  		$lParams['api_method'] = true;
  		//unset the param, that check, if user selected an existent payment method
  		unset($lParams['existing_pm_id']);

  		$this->pPaymentMethodForm->bind($lParams);
  		if($this->pPaymentMethodForm->isValid()){
  			$lPm = $this->pPaymentMethodForm->save();
  			$lText = "Der User ".$this->pUser->getFirstName()." ".$this->pUser->getLastName()." (".$this->pUser->getUsername().") ";
  			$lText .= "mit der Email-Adresse ".$this->pUser->getEmailAddress()." hat einen API Key beantragt. Um ihn zu bearbeiten bitte folgenden Link klicken: ";
  			$lText .= "http://www.spreadly.com/backend/...";
  			//app_settings_support_email
  			sfContext::getInstance()->getMailer()->composeAndSend( array(sfConfig::get("app_email_address") => sfConfig::get("app_email_sender")),  'karina@ekaabo.com', 'Neue Api Anfrage', $lText);
  			$this->redirect('advertiser/apply_api_thanks');
  		}
  	}

  }

  public function executeApply_api_thanks(sfWebRequest $request){
  	$this->pUser = $this->getUser()->getGuardUser();
  }
}

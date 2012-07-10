<?php
/**
 * domain_profiles actions.
 *
 * @package    yiid_stats
 * @subpackage domain_profiles
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class domain_profilesActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->getResponse()->setSlot('js_document_ready', $this->getPartial('domain_profiles/js_init_domain_profiles_handler.js'));
    $this->form = new DomainProfileForm();

    $this->domain_profiles = $this->getUser()->getDomainProfiles();
  }

  public function executeCreate(sfWebRequest $request)
  {
  	$this->getResponse()->setContentType('application/json');
    //$this->forward404Unless($request->isMethod(sfRequest::POST));
    $i18n = sfContext::getInstance()->getI18N();
    $form = new DomainProfileForm();
    $params = $request->getParameter($form->getName());
    $params['url'] = (isset($params['url']) && $params['url']!='') ? $this->cleanUrl($params['protocol'].'://'.$params['url']) : '';
    $params['sf_guard_user_id'] = $this->getUser()->getUserId();
    $form->bind($params, $request->getFiles($form->getName()));

    if ($form->isValid()) {
    	try{
        $domain_profile = $form->save();
    	} catch(Exception $e) {
	      return $this->renderText(
	        json_encode(array(
	          'success' => false,
	          'formerror' => $i18n->__('CREATE_DOMAIN_EXCEPTION_'.$e->getCode())
	        )));
    	}
      return $this->renderText(
        json_encode(array(
          'success' => true,
          'domain_profiles_table' => $this->getPartial('domain_profiles/domain_profiles_row', array('domain_profile' => $domain_profile, 'style' => 'style="display:none;"')),
          'host_id' => $domain_profile->getId()

        ))
      );
    } else {

    	foreach ($form->getErrorSchema()->getErrors() as $lError) {
        $lErrorString = $i18n->__($lError->getMessage()).'<br/>';
      }
      return $this->renderText(
        json_encode(array(
          'success' => false,
          'formerror' => $lErrorString
        )));
    }
  }

  public function executeGet_verify_code(sfWebRequest $request) {
  	$this->getResponse()->setContentType('application/json');
  	$lDomainProfile = Doctrine::getTable('DomainProfile')->find(array($request->getParameter('host_id')));

    //$token = '<meta name=\'microid\' content=\''.$domain_profile->getVerificationToken().'\' />';
    return $this->renderText(
      json_encode(array(
        'code' => $this->getPartial('domain_profiles/get_verify_code', array('domain_profile' => $lDomainProfile))
      ))
    );
  }

  public function executeDelete(sfWebRequest $request)
  {
  	$this->getResponse()->setContentType('application/json');
    //$request->checkCSRFProtection();
    $lDomainProfile = Doctrine::getTable('DomainProfile')->find(array($request->getParameter('host_id')));

    //$this->forward404Unless($domain_profile = Doctrine::getTable('DomainProfile')->find(array($request->getParameter('id'))), sprintf('Object domain_profile does not exist (%s).', $request->getParameter('id')));
    if($lDomainProfile && $this->getUser()->getUserId() == $lDomainProfile->getSfGuardUserId()) {
    	$lDomainProfile->delete();
	    return $this->renderText(
	      json_encode(array(
	        'success' => true,
	        'host_id' => $lDomainProfile->getId()
	      ))
	    );
    } else {
      return $this->renderText(
        json_encode(array(
          'success' => false,
          'error' => 'Your not allowed to delete this domain from analytics!'
        ))
      );
    }
    //$this->redirect('domain_profiles/index');
  }

  public function executeVerify(sfWebRequest $request)
  {
  	$this->getResponse()->setContentType('application/json');
    //$this->forward404Unless($domain_profile = Doctrine::getTable('DomainProfile')->find(array($request->getParameter('id'))), sprintf('Object domain_profile does not exist (%s).', $request->getParameter('id')));

    $lDomainProfile = Doctrine::getTable('DomainProfile')->find(array($request->getParameter('host_id')));
    //$this->domain_profiles = $this->getUser()->getDomainProfiles();

    $lVerified = $lDomainProfile->verify();
    $lHasError = ($lVerified === true)?false:$lVerified;
    if($lVerified == true) {
      return $this->renderText(
        json_encode(array(
          'success' => true,
          'host_id' => $lDomainProfile->getId(),
          'row' => $this->getPartial('domain_profiles/domain_profiles_row_content', array('domain_profile' => $lDomainProfile, 'pHasError' => $lHasError))
        ))
      );
    }
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $params = $request->getParameter($form->getName());
    $params['sf_guard_user_id'] = $this->getUser()->getUserId();
    $form->bind($params, $request->getFiles($form->getName()));

    if ($form->isValid())
    {
      $domain_profile = $form->save();
    }
    return $domain_profile;
  }

  private function cleanUrl($url) {
    $url = strtolower($url);
    return parse_url($url, PHP_URL_HOST);
  }




  public function executeSubscribe_api(sfWebRequest $request) {
  	$dm = MongoManager::getDM();
  	$this->pHostId = $request->getParameter('host_id');
    $this->pDomainProfile = Doctrine::getTable('DomainProfile')->find($this->pHostId);
    //gibt es nen endpoint? sollte mit in domain-profile-object und muss auch in index für die tabelle gesetzt sein pro domain-profile
    $this->pEndpoint = DomainSubscriptionsTable::getInstance()->findOneBy("domain_profile_id", $this->pDomainProfile->getId());
    $this->pOk = $dm->getRepository("Documents\PushJob")->countValidPuSHsLast24h($this->pHostId);
    $this->pTimeout = $dm->getRepository("Documents\PushJob")->countTimeoutPuSHsLast24h($this->pHostId);
    $this->pResponseFail = $dm->getRepository("Documents\PushJob")->countFailedPuSHsLast24h($this->pHostId);
  }

  public function executeCheck_endpoint(sfWebRequest $request) {
  	$this->getResponse()->setContentType('application/json');
  	$lUrl = $request->getParameter('ep-url');
  	$lHostId = $request->getParameter('host_id');
    $lDomainProfile = Doctrine::getTable('DomainProfile')->find($lHostId);
		$lVerified = PubSubHubbub::verifyCallback($lDomainProfile->getDomain(), $lUrl);

	  $lReturn = array();
		if($lVerified === true) {
			$lEndpoint = new DomainSubscriptions();
			$lEndpoint->setDomainProfileId($lDomainProfile->getId());
			$lEndpoint->setCallback($lUrl);
			$lEndpoint->save();

			$lReturn['success'] = true;
      $lReturn['row'] = $this->getPartial('domain_profiles/domain_profiles_row_content', array('domain_profile' => $lDomainProfile, 'pHasError' => false));
    	$lReturn['host_id'] = $lDomainProfile->getId();
		} else {
			$lReturn['success'] = false;
    	$lReturn['msg'] = _('The Endpoint is not correct. Please check the url or your implementation. For more info read our <a href="http://code.google.com/p/spreadly/wiki/PuSH_API" target="_blank">api documentation</a>');
		}

  	return $this->renderText(
    	json_encode($lReturn)
    );
  }

  public function executeUnsubscribe_api(sfWebRequest $request) {
  	$this->getResponse()->setContentType('application/json');
  	//$lUrl = $request->getParameter('ep-url');
  	$lHostId = $request->getParameter('host_id');
    $lDomainProfile = Doctrine::getTable('DomainProfile')->find($lHostId);
		$lEndpoint = DomainSubscriptionsTable::getInstance()->findOneBy("domain_profile_id", $lDomainProfile->getId());
		$lEndpoint->delete();

  	return $this->renderText(
    	json_encode(array(
    		'success' => true,
    		'msg' => _('Subscription stopped'),
        'row' => $this->getPartial('domain_profiles/domain_profiles_row_content', array('domain_profile' => $lDomainProfile, 'pHasError' => false)),
    		'host_id' => $lDomainProfile->getId()
    	))
    );
  }

  public function executeTracking_url(sfWebRequest $request) {
    $this->info = $this->error = null;
    $host_id = $request->getParameter("host_id", null);

    if (!$host_id) {
      $this->redirect('domain_profiles/index');
    }

    $domainProfile = DomainProfileTable::getInstance()->find($host_id);

    if ($request->getMethod() == "POST") {
      $trackingUrl = $request->getParameter("tracking_url", null);
      if (trim($trackingUrl)) {
        if (UrlUtils::isUrlValid($trackingUrl)) {
          $domainProfile->setTrackingUrl($trackingUrl);
          $domainProfile->save();

          $this->info = "URL successfully saved.";
        } else {
          $this->error = "URL is not valid.";
        }
      } else {
        $domainProfile->setTrackingUrl(null);
        $domainProfile->save();

        $this->info = "URL successfully deleted.";
      }
    }

    $this->domainProfile = $domainProfile;
  }

  public function executeAdd_flattr(sfWebRequest $request) {
    $this->info = $this->error = null;

    $host_id = $request->getParameter("host_id", null);

    if (!$host_id) {
      $this->redirect('domain_profiles/index');
    }

    $domainProfile = DomainProfileTable::getInstance()->find($host_id);

    if ($request->getMethod() == "POST") {
      $flattr_account = $request->getParameter("flattr_account", null);
      if (trim($flattr_account)) {
        if (UrlUtils::checkUrlAvailability("http://flattr.com/submit/auto?url=".urlencode($domainProfile->getDomain())."&flattr_id=".$flattr_account)) {
          $domainProfile->setFlattrAccount($flattr_account);
          $domainProfile->save();

          $this->info = "flattr-account successfully added.";
        } else {
          $this->error = "URL is not valid.";
        }
      } else {
        $domainProfile->setFlattrAccount(null);
        $domainProfile->save();

        $this->info = "flattr-account deleted.";
      }
    }

    $this->domainProfile = $domainProfile;
  }
}

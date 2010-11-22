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
    $params['url'] = isset($params['url'])?strtolower($params['url']):'';
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
}

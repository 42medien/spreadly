<?php

/**
 * configurator actions.
 *
 * @package    yiid
 * @subpackage configurator
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class configuratorActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
  	$this->getResponse()->setSlot('js_document_ready', $this->getPartial('configurator/js_init_configurator.js'));
    //$this->forward('default', 'module');
  }

  public function executeConfig(sfWebRequest $request){
  	$this->getResponse()->setSlot('js_document_ready', $this->getPartial('configurator/js_init_configurator.js'));
  }

  public function executeGet_choose_style(sfWebRequest $request){
    $this->getResponse()->setContentType('application/json');
    $lServiceId = $request->getParameter('service', null);

    $lService = null;
    if($lServiceId == 'static') {
    	$lService = new SupportedServices();
    	$lService->setName('static');
    	$lService->setSlug('static');
    } else if($lServiceId && $lServiceId != 'static') {
      $lService = SupportedServicesTable::getInstance()->find($lServiceId);
    }

    $lReturn['html'] = $this->getPartial('configurator/choose_style', array('pService' => $lService));

    return $this->renderText(json_encode($lReturn));
  }


  public function executeGet_buttoncode(sfWebRequest $request) {
  	$this->getResponse()->setContentType('application/json');
		$lParams = $request->getParameter('likebutton');
    $lUrl = "http://www.spreadly.com";
    $lSocial = 0;

		if(isset($lParams['url']) && UrlUtils::isUrlValid($lParams['url'])){
      $lUrl = $lParams['url'];
    }

    if(isset($lParams['wt']) && $lParams['wt'] == 'stand_social'){
    	$lSocial = 1;
    }

  	$lService = (isset($lParams['service']))?$lParams['service']:null;
  	if($lService) {
  		$lHeight = ($lSocial == 1)?"60": "30";

	  	$lReturn['iframe'] = $this->getPartial('configurator/widget_'.$lService, array('pUrl' => $lUrl, 'pSocial' => $lSocial, 'pHeight' => $lHeight));
  	} else {

  		if($lSocial == 0) {
	  		$lReturn['iframe'] = $this->getPartial('configurator/widget_like_code', array('pUrl' => $lUrl));
  		} else {
	  		$lReturn['iframe'] = $this->getPartial('configurator/widget_full_code', array('pUrl' => $lUrl));
  		}
  	}



    return $this->renderText(json_encode($lReturn));
  }

  public function executeGet_button(sfWebRequest $request) {
    $this->getResponse()->setContentType('application/json');
    $lParams = $request->getParameter('likebutton');
    $lUrl = "http://www.spreadly.com";

    $lSocial = 0;
		if(isset($lParams['url']) && UrlUtils::isUrlValid($lParams['url'])){
      $lUrl = $lParams['url'];
    }
    if(isset($lParams['wt']) && $lParams['wt'] == 'stand_social'){
    	$lSocial = 1;
    }

    if(isset($lParams['text'])){
    	$lLabel = $lParams['text'];
    }

   	if(isset($lParams['color'])){
    	$lColor = $lParams['color'];
    }

  	$lService = (isset($lParams['service']))?$lParams['service']:null;

   	$lReturn['iframe'] = $this->getPartial('configurator/preview_widgets', array('pUrl' => $lUrl, 'pSocial' => $lSocial, 'pService' => $lService));
    return $this->renderText(json_encode($lReturn));
  }
}

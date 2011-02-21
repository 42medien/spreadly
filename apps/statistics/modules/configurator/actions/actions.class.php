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

  public function executeGet_choose_style(sfWebRequest $request){
    $this->getResponse()->setContentType('application/json');
    $lServiceId = $request->getParameter('service', null);

    $lService = null;
    if($lServiceId) {
      $lService = SupportedServicesTable::getInstance()->find($lServiceId);
    }

    $lReturn['html'] = $this->getPartial('configurator/choose_style', array('pService' => $lService));

    return $this->renderText(json_encode($lReturn));
  }


  public function executeGet_buttoncode(sfWebRequest $request) {
  	$this->getResponse()->setContentType('application/json');
		$lParams = $request->getParameter('likebutton');
    $lUrl = "http://www.spreadly.com";
    $lLang = "en";
		if(isset($lParams['url']) && UrlUtils::isUrlValid($lParams['url'])){
      $lLang = $lParams['url'];
    }
  	if(isset($lParams['l']) && UrlUtils::isUrlValid($lParams['l'])){
      $lLang = $lParams['l'];
    }

  	$lService = (isset($lParams['service']))?$lParams['service']:null;
  	if($lService) {

	  	$lReturn['iframe'] = $this->getPartial('configurator/widget_'.$lService, array('pUrl' => $lUrl, 'pLang' => $lLang));
  	} else {
	  	$lReturn['iframe'] = $this->getPartial('configurator/widget_like', array('pUrl' => $lUrl, 'pLang' => $lLang));
  	}



    return $this->renderText(json_encode($lReturn));
  }

  public function executeGet_button(sfWebRequest $request) {
    $this->getResponse()->setContentType('application/json');
    $lParams = $request->getParameter('likebutton');
    $lUrl = "http://www.spreadly.com";
    $lLang = "en";
		if(isset($lParams['url']) && UrlUtils::isUrlValid($lParams['url'])){
      $lLang = $lParams['url'];
    }
  	if(isset($lParams['l']) && UrlUtils::isUrlValid($lParams['l'])){
      $lLang = $lParams['l'];
    }

   	$lReturn['iframe'] = $this->getPartial('configurator/preview_widgets', array('pUrl' => $lParams['url'], 'pLang' => $lParams['l']));
    return $this->renderText(json_encode($lReturn));
  }
}

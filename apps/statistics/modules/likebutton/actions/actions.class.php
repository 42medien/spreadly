<?php
//require_once 'Zend/Http/Client.php';
/**
 * likebutton actions.
 *
 * @package    yiid
 * @subpackage likebutton
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class likebuttonActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request) {
    $this->getResponse()->setSlot('js_document_ready', $this->getPartial('likebutton/js_init_likebutton.js'));
  }


  public function executeGet_button(sfWebRequest $request) {
    $this->getResponse()->setContentType('application/json');
    $lParams = $request->getParameter('likebutton');
    $lReturn = array();
    //$lReturn['email'] = $lParams['email'];
    $lUrl='http://www.yiid.com';
    $lWidth = 420;
    $lHeight = 25;
    $lLang = $lParams['l'];
    $lType = (isset($lParams['t']))?$lParams['t']:'like';
    $lFontColor = $lParams['fc'];
    $lWidgetType = (isset($lParams['wt']))?$lParams['wt']:'stand';
    $lShortVersion = '';
    $lSocialVersion = '';


    //if language is not set, default session lang
    if($lLang == '') {
      $lLang = sfContext::getInstance()->getUser()->getCulture();
    }

    // if no fontcolor, default black
    if(!isset($lParams['fc']) || $lParams['fc'] == ''){
      $lFontColor = '#000000';
    }

    if(isset($lParams['url']) && UrlUtils::isUrlValid($lParams['url'])){
      $lUrl = $lParams['url'];
    }

    if(isset($lParams['sh']) && $lParams['sh'] == 'on') {
      $lShortVersion = 1;
    }

    if(isset($lParams['so']) && $lParams['so'] == 'on') {
      $lSocialVersion = 1;
      $lHeight = 62;
    }

    if(isset($lParams['bt']) && $lParams['bt'] == 'on') {
      $lWidth = WidgetWidthRegistry::getOptimalFullWidth($lShortVersion, $lWidth, $lType, $lLang);
      $lReturn['iframe'] = $this->getPartial('likebutton/preview_widgets_full', array('pUrl' => $lUrl, 'pWidth' => $lWidth, 'pLang' => $lLang, 'pType'=>$lType, 'pFontColor' => $lFontColor, 'pShort' => $lShortVersion, 'pSocial' => $lSocialVersion, 'pHeight' => $lHeight, 'pWidgetType' => $lWidgetType));
    } else {
      $lWidth = WidgetWidthRegistry::getOptimalLikeWidth($lShortVersion, $lWidth, $lType, $lLang);
      $lReturn['iframe'] = $this->getPartial('likebutton/preview_widgets', array('pUrl' => $lUrl, 'pWidth' => $lWidth, 'pLang' => $lLang, 'pType'=>$lType, 'pFontColor' => $lFontColor, 'pShort' => $lShortVersion, 'pSocial' => $lSocialVersion, 'pHeight' => $lHeight, 'pWidgetType' => $lWidgetType));
    }

    return $this->renderText(json_encode($lReturn));
  }

  public function executeSend_email(sfWebRequest $request) {
    $this->getResponse()->setContentType('application/json');
    $lEmail = $request->getParameter('email');
    if(preg_match('/^([^@\s]+)@((?:[-a-z0-9]+\.)+[a-z]{2,})$/i', $lEmail)){

      $lClient = new Zend_Http_Client(null, array('useragent' => 'YIID/0.1 (Availability Checker; http://www.yiid.com/; Allow like Gecko)'));
      $lClient->setUri('http://redirect2.mailingwork.de/addabo.php');
      $lClient->setMethod(Zend_Http_Client::POST);
      $lClient->setEncType(Zend_Http_Client::ENC_FORMDATA);
      $lClient->setParameterPost(
        array(
          'email' => $lEmail,
          'formtype' => 'eMail',
          'customerID' => 'MTA2MA%3D%3D',
          'Liste[1]' => 'MTcyMzQ%3D',
          'forceCharset' => 'utf-8'
      ));
      $lClient->setConfig(array('timeout' => 15));
      $lResponse = $lClient->request();
    }

    return $this->renderText('true');
  }

  /**
   * Action for non-profits
   *
   * @author Christian Schätzle
   * @param $request
   */
  public function executeNonprofits(sfWebRequest $request) {

  }

  /**
   * Action for publishers
   *
   * @author Christian Schätzle
   * @param $request
   */
  public function executePublishers(sfWebRequest $request) {

  }

  /**
   * Action for shops
   *
   * @author Christian Schätzle
   * @param $request
   */
  public function executeShops(sfWebRequest $request) {

  }

  /**
   * Action for webmasters site
   *
   * @author Christian Schätzle
   * @param $request
   */
  public function executeWebmasters(sfWebRequest $request) {

  }

  /**
   * Action for updating the label for ifram width
   *
   * @author Christian Schätzle
   * @param sfWebRequest $request
   */
  public function executeUpdate_width_label(sfWebRequest $request) {
    $this->getResponse()->setContentType('application/json');

    $lGlobalType = $request->getParameter('global_type');
    $lType = $request->getParameter('type');
    $lLanguage = $request->getParameter('lang');
    $lShortVersion = $request->getParameter('short_version');

    $lWidth = WidgetWidthRegistry::getWidthForLabel($lGlobalType, $lType, $lLanguage, $lShortVersion);

    $lReturn['html'] = $lWidth;

    return $this->renderText(json_encode($lReturn));
  }

  /**
   * sends the choose_style partial as json
   *
   * @author Christian Schätzle
   * @param sfWebRequest $request
   */
  public function executeGet_choose_style(sfWebRequest $request) {
    $this->getResponse()->setContentType('application/json');
    $lServiceId = $request->getParameter('service', null);

    if($lServiceId) {
      $lService = SupportedServicesTable::getInstance()->find($lServiceId);
    }

    $lReturn['html'] = $this->getPartial('likebutton/choose_style', array('pService' => $lService));
    $lReturn['type'] = "dynamic";

    return $this->renderText(json_encode($lReturn));
  }

  /**
   * sends the choose_app partial as json
   *
   * @author Christian Schätzle
   * @param sfWebRequest $request
   */
  public function executeGet_choose_app(sfWebRequest $request) {
  	$this->getResponse()->setContentType('application/json');

    $lReturn['html'] = $this->getComponent('likebutton','choose_app');

    return $this->renderText(json_encode($lReturn));
  }

  public function executeGet_choose_email_signatures(sfWebRequest $request) {
    $this->getResponse()->setContentType('application/json');

    $lReturn['html'] = $this->getPartial('likebutton/email_signatures');
    $lReturn['type'] = "static";

    return $this->renderText(json_encode($lReturn));
  }


  public function executeGet_buttoncode(sfWebRequest $request) {
    $this->getResponse()->setContentType('application/json');
    $lParams = $request->getParameter('likebutton');
    $lReturn = array();
    $lUrl='http://www.yiid.com';
    $lWidth = 420;
    $lHeight = 25;
    $lLang = $lParams['l'];
    $lType = (isset($lParams['t']))?$lParams['t']:'like';
    $lFontColor = $lParams['fc'];
    $lWidgetType = (isset($lParams['wt']))?$lParams['wt']:'stand';
    $lShortVersion = false;
    $lSocialVersion = false;
    $lService = (isset($lParams['service']))?$lParams['service']:null;


    //if language is not set, default session lang
    if($lLang == '') {
      $lLang = sfContext::getInstance()->getUser()->getCulture();
    }

    // if no fontcolor, default black
    if(!isset($lParams['fc']) || $lParams['fc'] == ''){
      $lFontColor = '#000000';
    }

    if(isset($lParams['url']) && UrlUtils::isUrlValid($lParams['url'])){
      $lUrl = $lParams['url'];
    }

    //if width ist not set or no number, take default width
    if(StringUtils::isNumber($lParams['w'])){
      $lWidth = $lParams['w'];
    }

    if($lWidgetType == 'short') {
      $lShortVersion = true;
      $lSocialVersion = false;
    } elseif($lWidgetType == 'short_social') {
      $lShortVersion = true;
      $lSocialVersion = true;
    }elseif($lWidgetType == 'stand_social') {
      $lShortVersion = false;
      $lSocialVersion = true;
    }
    if($lSocialVersion) {
      $lHeight = 65;
    }

    if(isset($lParams['bt']) && $lParams['bt'] == 'on') {
      $lWidth = WidgetWidthRegistry::getOptimalFullWidth($lShortVersion, $lWidth, $lType, $lLang);
      if($lService) {
        $lReturn['iframe'] = $this->getPartial('likebutton/widget_'.$lService, array('pWidgetSize'=>'full' ,'pUrl' => $lUrl, 'pWidth' => $lWidth, 'pLang' => $lLang, 'pType'=>$lType, 'pFontColor' => $lFontColor, 'pShort' => $lShortVersion, 'pSocial' => $lSocialVersion, 'pHeight' => $lHeight, 'pWidgetType' => $lWidgetType));
      } else {
        $lReturn['iframe'] = $this->getPartial('likebutton/widget_full', array('pUrl' => $lUrl, 'pWidth' => $lWidth, 'pLang' => $lLang, 'pType'=>$lType, 'pFontColor' => $lFontColor, 'pShort' => $lShortVersion, 'pSocial' => $lSocialVersion, 'pHeight' => $lHeight, 'pWidgetType' => $lWidgetType));
      }
    } else {
      $lWidth = WidgetWidthRegistry::getOptimalLikeWidth($lShortVersion, $lWidth, $lType, $lLang);
      if($lService) {
        $lReturn['iframe'] = $this->getPartial('likebutton/widget_'.$lService, array('pWidgetSize'=>'like' ,'pUrl' => $lUrl, 'pWidth' => $lWidth, 'pLang' => $lLang, 'pType'=>$lType, 'pFontColor' => $lFontColor, 'pShort' => $lShortVersion, 'pSocial' => $lSocialVersion, 'pHeight' => $lHeight, 'pWidgetType' => $lWidgetType));
      } else {
        $lReturn['iframe'] = $this->getPartial('likebutton/widget_like', array('pUrl' => $lUrl, 'pWidth' => $lWidth, 'pLang' => $lLang, 'pType'=>$lType, 'pFontColor' => $lFontColor, 'pShort' => $lShortVersion, 'pSocial' => $lSocialVersion, 'pHeight' => $lHeight, 'pWidgetType' => $lWidgetType));
      }
    }
    return $this->renderText(json_encode($lReturn));
  }

  public function executeGet_static_code(sfWebRequest $request) {
    $this->getResponse()->setContentType('application/json');
    //var_dump('fds');die();
    $lParams = $request->getParameter('static_button');
    $lReturn = array();
    $lReturn['codetype'] = 'img';
    $lUrl = 'http://www.yiid.com';
    $lLang = $lParams['l'];

    if($lParams['text'] == 'text'){
    	$lText = $lParams['text_value'];
      $lReturn['codetype'] = 'text';
    } else {
    	$lText = null;
    }
    $lFull = (isset($lParams['bt']) && $lParams['bt'] == 'on')?1:0;
    if(isset($lParams['url']) && UrlUtils::isUrlValid($lParams['url'])){
      $lUrl = $lParams['url'];
    }
      //if language is not set, default session lang
    if($lLang == '') {
      $lLang = 'en';
    }

    $lReturn['textcode'] = $this->getPartial('likebutton/text_code', array('pWidgetSize'=>$lFull ,'pUrl' => $lUrl, 'pText' => $lText, 'pLang' => $lLang));
    $lReturn['imgcode'] = $this->getPartial('likebutton/img_code', array('pWidgetSize'=>$lFull ,'pUrl' => $lUrl, 'pText' => $lText, 'pLang' => $lLang));

    return $this->renderText(json_encode($lReturn));
  }
}

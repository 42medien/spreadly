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

  }


  public function executeGet_button(sfWebRequest $request) {
    $this->getResponse()->setContentType('application/json');
    $lParams = $request->getParameter('likebutton');
    $lReturn = array();
    $lReturn['email'] = $lParams['email'];
    $lUrl='';
    $lWidth = 0;
    $lLang = $lParams['l'];
    $lType = $lParams['t'];
    $lFontColor = $lParams['fc'];

    //if type is not set, default like
    if($lType == '') {
    	$lType = 'like';
    }

    //if language is not set, default session lang
    if($lLang == '') {
    	$lLang = sfContext::getInstance()->getUser()->getCulture();
    }

    // if no fontcolor, default black
    if(!isset($lParams['fc']) || $lParams['fc'] == ''){
    	$lFontColor = '#000000';
    }

    if(UrlUtils::isUrlValid($lParams['url'])){
    	$lUrl = $lParams['url'];
    }

    //if width ist not set or no number, take default width
    if(StringUtils::isNumber($lParams['w'])){
      $lWidth = $lParams['w'];
    }

    if($lParams['bt'] == 'on') {
      $lWidth = WidgetWidthRegistry::getOptimalFullWidth($lWidth, $lType, $lLang);
      $lReturn['iframe'] = $this->getPartial('likebutton/widget_full', array('pUrl' => $lUrl, 'pWidth' => $lWidth, 'pLang' => $lLang, 'pType'=>$lType, 'pFontColor' => $lFontColor));
    } else {
      $lWidth = WidgetWidthRegistry::getOptimalLikeWidth($lWidth, $lType, $lLang);
      $lReturn['iframe'] = $this->getPartial('likebutton/widget_like', array('pUrl' => $lUrl, 'pWidth' => $lWidth, 'pLang' => $lLang, 'pType'=>$lType, 'pFontColor' => $lFontColor));
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

  	$lWidth = WidgetWidthRegistry::getWidthForLabel($lGlobalType, $lType, $lLanguage);

  	$lReturn['html'] = $lWidth;

  	return $this->renderText(json_encode($lReturn));
  }
}

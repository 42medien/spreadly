<?php

/**
 * deal actions.
 *
 * @package    yiid
 * @subpackage deal
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class dealActions extends sfActions
{

  public function executeIndex(sfWebRequest $request) {
      $this->getUser()->setAttribute("redirect_after_login", $request->getUri(), "static_button");

    $this->getResponse()->setSlot('js_document_ready', $this->getPartial('popup/js_popup_ready'));
    $this->getResponse()->setSlot('js_document_ready', $this->getPartial('deal/js_deal_ready'));
    //$this->getResponse()->setSlot('js_document_ready', $this->getPartial('static/js_init_static.js'));

    $this->pIsUrlValid = true;
    $lUrl = $request->getParameter('url', '');

    if (!empty($lUrl) && UrlUtils::isUrlValid($lUrl)) {
      $lUrl = urldecode($lUrl);
	    $lUser = $this->getUser()->getUser();

	    $lSocialObject = SocialObjectTable::retrieveByAliasUrl($lUrl);
      $this->pIsUsed = false;
      if($lSocialObject) {
        $this->pIsUsed = YiidACtivityTable::getActionOnObjectByUser($lSocialObject->getId(), $this->getUser()->getUserId());
      }

    } else {
      $this->pIsUrlValid = false;
    }

    $this->pIdentities = OnlineIdentityTable::getPublishingEnabledByUserId($this->getUser()->getUserId());
    $this->pUrl = $lUrl;
    $this->pTitle = $request->getParameter('title', '');
    $this->pDescription = $request->getParameter('description', '');
    $this->pType = $request->getParameter('type', 'like');
    $this->pFull = $request->getParameter('full', 0);
    $this->pImageUrl = $request->getParameter('imageurl', null);


    if (!in_array($this->pType, YiidActivityTable::$aTypes)) {
      $this->pType = "like";
    }

    CookieUtils::generateWidgetIdentityCookie($this->pIdentities);
    sfProjectConfiguration::getActive()->loadHelpers('I18N');
    //$this->getUser()->setFlash('headline', __('Settings', null, 'widget'));
    //$this->setLayout('layout_twocol');
  }

  public function executeUsed($request){

  }

  public function executeGet_coupon(sfWebRequest $request) {
    $this->getResponse()->setContentType('application/json');
    return $this->renderText(
      json_encode(
        array(
          'success' => true,
          'html'  => $this->getComponent('deal','used_popup'),
        )
      )
    );
  }
}
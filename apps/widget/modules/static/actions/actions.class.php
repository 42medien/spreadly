<?php
/**
 * static actions.
 *
 * @package    yiid
 * @subpackage static
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class staticActions extends sfActions {
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request) {
    $this->redirect('@static_like');
  }

  public function executeLike(sfWebRequest $request) {
    if ($request->getParameter("url", null)) {
      $this->getUser()->setAttribute("static_like_with_params", $request->getUri(), "popup");
      $this->getUser()->setAttribute("redirect_after_login", $request->getUri(), "popup");
    } elseif ($lUrl = $this->getUser()->getAttribute("static_like_with_params", null, "popup")) {
      $this->redirect($lUrl);
    }

    $this->getResponse()->setSlot('js_document_ready', $this->getPartial('popup/js_popup_ready'));
    $this->getResponse()->setSlot('js_document_ready', $this->getPartial('static/js_init_static.js'));

    $this->pIsUrlValid = true;
    $lUrl = $request->getParameter('url', '');
    $lUrl = urldecode($lUrl);

    if (!empty($lUrl) && UrlUtils::isUrlValid($lUrl)) {
      $lUrl = urldecode($lUrl);
	    $lUser = $this->getUser()->getUser();

	    $lSocialObject = SocialObjectTable::retrieveByAliasUrl($lUrl);
	    $lDeal = DealTable::getActiveDealByUrlAndUserId($lUrl, $this->getUser()->getUserId());

      $this->pIsUsed = false;
      if($lSocialObject) {
        $this->pIsUsed = YiidACtivityTable::getActionOnObjectByUser($lSocialObject->getId(), $this->getUser()->getUserId(), $lDeal);
        $this->pYiidActivity = YiidActivityTable::retrieveActionOnObjectById($lSocialObject->getId(), $this->getUser()->getUserId(), $lDeal);
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
    $this->getUser()->setFlash('headline', __('Like & Dislike', null, 'widget'));
    $this->pDeal = $lDeal;
    $this->setLayout('layout_onecol');
  }

  public function executeSettings(sfWebRequest $request) {
    $this->getResponse()->setSlot('js_document_ready', $this->getPartial('popup/js_popup_ready'));
    $this->getUser()->setFlash('headline', __('SETTINGS', null, 'widget'));

    $this->getUser()->setAttribute("redirect_after_login", $request->getUri(), "popup");

    $lUser = $this->getUser()->getUser();
    if($request->getMethod() == sfRequest::POST) {
      $checkedOnlineIdentities = $request->getParameter('enabled_services', array());

      // @todo define methods in objects
      OnlineIdentityTable::toggleSocialPublishingStatus($this->getUser()->getUser()->getOnlineIdentitesAsArray(), $checkedOnlineIdentities);
    }

    $this->pIdentities = OnlineIdentityTable::getPublishingEnabledByUserId($this->getUser()->getUserId());

    CookieUtils::generateWidgetIdentityCookie($this->pIdentities);
    sfProjectConfiguration::getActive()->loadHelpers('I18N');

    $this->setLayout('layout_twocol');
  }
}

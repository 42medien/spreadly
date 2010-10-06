<?php
/**
 * static actions.
 *
 * @package    yiid
 * @subpackage static
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class staticActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('default', 'module');
  }

  public function executeSignin(sfWebRequest $request) {
  }


  public function executeLike(sfWebRequest $request){
    $this->getResponse()->setSlot('js_document_ready', $this->getPartial('popup/js_popup_ready'));
    $this->getResponse()->setSlot('js_document_ready', $this->getPartial('static/js_init_static.js'));

    $this->pIsUrlValid = true;
    $lUrl = $request->getParameter('url', 'http://www.spiegel.de');
    if (!empty($lUrl) && UrlUtils::isUrlValid($lUrl)) {
      $lUrl = urldecode(UrlUtils::skipTrailingSlash($lUrl));

	    $lTitle = $request->getParameter('title');
	    $lDescription = $request->getParameter('description');
	    $lType = $request->getParameter('type', 'like');

	    $lUser = $this->getUser()->getUser();
	    if($request->getMethod() == sfRequest::POST) {
	      $checkedOnlineIdentities = $request->getParameter('enabled_services', array());
	      //@todo define methods in objects
	      OnlineIdentityTable::toggleSocialPublishingStatus(UserIdentityConTable::getOnlineIdentityIdsForUser($this->getUser()->getId()), $checkedOnlineIdentities);

	      if (array_key_exists("yiid_temp_hash", $_COOKIE)) {
	        $lTempData = YiidActivityTable::getTemporaryData($_COOKIE["yiid_temp_hash"]);
	        setcookie("yiid_temp_hash", '', time()-3600, '/', sfConfig::get('app_settings_host'));

	        if ($lTempData) {
	          $lStatus = YiidActivityTable::saveLikeActivitys($this->getUser()->getId(),
	                                              $lTempData["url"],
	                                              //@todo define methods in objects
	                                              UserIdentityConTable::getOnlineIdentityIdsForUser($this->getUser()->getId()),
	                                              OnlineIdentityTable::getPublishingEnabledByUserIdOnlyIds($this->getUser()->getId()),
	                                              $lTempData["score"],
	                                              $lTempData["verb"],
	                                              $lTempData["title"],
	                                              $lTempData["description"],
	                                              $lTempData["photo"]);
	        }
	      }

	      $this->getUser()->setAttribute("yiid_temp_hash", null);
	      //$this->getUser()->setFlash("onload", "window.close();", false);
	    }

      $lSocialObject = SocialObjectTable::retrieveByAliasUrl($lUrl);
      $this->pIsUsed = false;
      if($lSocialObject) {
        $this->pIsUsed = YiidACtivityTable::isActionOnObjectAllowed($lSocialObject->getId(), $this->getUser()->getUserId());
      }

    } else {
      $this->pIsUrlValid = false;
    }
    $this->pIdentities = OnlineIdentityTable::getPublishingEnabledByUserId($this->getUser()->getUserId());
    $this->pUrl = $lUrl;
    $this->pTitle = $lTitle;
    $this->pDescription = $lDescription;
    $this->pType = $lType;

    CookieUtils::generateWidgetIdentityCookie($this->pIdentities);
    sfProjectConfiguration::getActive()->loadHelpers('I18N');
    $this->getUser()->setFlash('headline', __('SETTINGS', null, 'widget'));
    $this->setLayout('layout_twocol');
  }
}

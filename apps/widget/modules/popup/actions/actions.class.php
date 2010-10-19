<?php

/**
 * popup actions.
 *
 * @package    yiid
 * @subpackage popup
 * @author     Matthias Pfefferle
 * @author     Christian Schätzle
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class popupActions extends sfActions {

  public function executeError(sfWebRequest $request) {
    $this->getResponse()->setSlot('js_document_ready', $this->getPartial('popup/js_popup_ready'));
    sfProjectConfiguration::getActive()->loadHelpers('I18N');
    $this->getUser()->setFlash('headline', __('ERROR', null, 'widget'));

    $this->getUser()->setFlash('error', 'Folgede Fehler sind aufgetreten:');
  }

  public function executeSettings(sfWebRequest $request) {
    $this->getResponse()->setSlot('js_document_ready', $this->getPartial('popup/js_popup_ready'));

    $lUser = $this->getUser()->getUser();
    if($request->getMethod() == sfRequest::POST) {
      $checkedOnlineIdentities = $request->getParameter('enabled_services', array());
      //@todo define methods in objects
      OnlineIdentityTable::toggleSocialPublishingStatus($this->getUser()->getUser()->getOnlineIdentities(), $checkedOnlineIdentities);

      if (array_key_exists("yiid_temp_hash", $_COOKIE)) {
        $lTempData = YiidActivityTable::getTemporaryData($_COOKIE["yiid_temp_hash"]);
        setcookie("yiid_temp_hash", '', time()-3600, '/', sfConfig::get('app_settings_host'));

        if ($lTempData) {
          $lStatus = YiidActivityTable::saveLikeActivitys($this->getUser()->getId(),
                                              $lTempData["url"],
                                              //@todo define methods in objects
                                              $this->getUser()->getUser()->getOnlineIdentities(),
                                              OnlineIdentityTable::getPublishingEnabledByUserIdOnlyIds($this->getUser()->getId()),
                                              $lTempData["score"],
                                              $lTempData["verb"],
                                              $lTempData["title"],
                                              $lTempData["description"],
                                              $lTempData["photo"]);
        }
      }

      $this->getUser()->setAttribute("yiid_temp_hash", null);
      $this->getUser()->setFlash("onload", "window.close();", false);
    }

    $this->pIdentities = OnlineIdentityTable::getPublishingEnabledByUserId($this->getUser()->getUserId());

    CookieUtils::generateWidgetIdentityCookie($this->pIdentities);
    sfProjectConfiguration::getActive()->loadHelpers('I18N');
    $this->getUser()->setFlash('headline', __('SETTINGS', null, 'widget'));
    $this->setLayout('layout_twocol');
  }
}

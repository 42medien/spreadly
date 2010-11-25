<?php

class popupComponents extends sfComponents
{

  /**
   * component for spread_description
   *
   * @author Christian Schätzle
   *
   * @param sfWebRequest $request
   */
  public function executeSpread_description(sfWebRequest $request) {}

  /**
   * component for welcome_user
   *
   * @author Christian Schätzle
   *
   * @param sfWebRequest $request
   */
  public function executeWelcome_user(sfWebRequest $request) {
    $this->pContext = $request->getParameter("widgetcontext", $request->getParameter('module'));
    $this->pUser = $this->getUser()->getUser();
  }

  public function executeSettings(sfWebRequest $request){
    $lUser = $this->getUser()->getUser();
    if($request->getMethod() == sfRequest::POST) {
      $checkedOnlineIdentities = $request->getParameter('enabled_services', array());

      //@todo define methods in objects
      OnlineIdentityTable::toggleSocialPublishingStatus($this->getUser()->getUser()->getOnlineIdentitesAsArray(), $checkedOnlineIdentities);

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
  }

}
?>
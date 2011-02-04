<?php

/**
 * settings actions.
 *
 * @package    yiid
 * @subpackage settings
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class settingsActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request) {
    $this->getUser()->setAttribute("redirect_after_login", null, "widget");

    $lUser = $this->getUser()->getUser();
    if($request->getMethod() == sfRequest::POST) {
      $checkedOnlineIdentities = $request->getParameter('enabled_services', array());

      // @todo define methods in objects
      OnlineIdentityTable::toggleSocialPublishingStatus($this->getUser()->getUser()->getOnlineIdentitesAsArray(), $checkedOnlineIdentities);
    }

    $this->pUser = $this->getUser()->getUser();
    $this->pIdentities = OnlineIdentityTable::getPublishingEnabledByUserId($this->getUser()->getUserId());

    CookieUtils::generateWidgetIdentityCookie($this->pIdentities);
    sfProjectConfiguration::getActive()->loadHelpers('I18N');
    $this->setLayout('layout');
  }
}

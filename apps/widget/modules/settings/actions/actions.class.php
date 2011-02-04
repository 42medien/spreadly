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
  public function executeIndex(sfWebRequest $request)
  {
    $this->getResponse()->setSlot('js_document_ready', $this->getPartial('settings/js_init_settings.js'));
    $this->getUser()->setFlash('headline', __('SETTINGS', null, 'widget'));

    //$this->getUser()->setAttribute("redirect_after_login", $request->getUri(), "popup");

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

  public function executeUpdate(sfWebRequest $request) {
  	$this->getResponse()->setContentType('application/json');

  	return true;
  }
}

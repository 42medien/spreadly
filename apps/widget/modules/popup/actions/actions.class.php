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

  /**
   * Executes index action
   *
   * @param sfRequest $request A request object
   */
  public function executeSignin(sfWebRequest $request) {
    $this->getResponse()->setSlot('js_document_ready', $this->getPartial('popup/js_popup_ready'));
    if ($this->getUser()->isAuthenticated()) {
      $this->redirect("@settings");
    }

    sfProjectConfiguration::getActive()->loadHelpers('I18N');
    $this->getUser()->setFlash('headline', __('SETTINGS', null, 'widget'));


    /* Uncomment for displaying error
     $this->getUser()->setFlash('headline', 'Login');
     $this->getUser()->setFlash('error', 'You have been logged out.');
     $this->getUser()->setFlash('error_msg', 'Please choose the same service you have used the last time to log in again.');
     */
  }

  public function executeSignout(sfWebRequest $request) {
    $this->getUser()->signOut();
    $this->redirect('@signin');
  }

  public function executeConfirm_signin(sfWebRequest $request) {
    $this->getResponse()->setSlot('js_document_ready', $this->getPartial('popup/js_confirm_signin_ready'));

    if ($this->getUser()->isAuthenticated()) {
      $this->redirect("@settings");
    }

    $lToken = $request->getParameter('token');
    $lRpxClient = new RpxClient();

    try {
      $lProfile = $lRpxClient->authenticate($lToken);

      $this->pIdentifier = $lProfile['profile']['identifier'];
    } catch (Exception $e) {
      sfContext::getInstance()->getLogger()->err("{yiidException} ".$e->getMessage());
      $this->getUser()->setFlash('error', $e->getMessage());
      $this->redirect('@signin');
    }

    if ($lAuthIdentifier = OnlineIdentityPeer::retrieveByAuthIdentifier($lProfile['profile']['identifier'])) {
      $lUser = $lAuthIdentifier->getRelatedUser();

      if ($lUser) {
        // check if user is active
        if ($lUser->getActive()) {
          $this->getUser()->signIn($lUser);
          $lRpxClient->doSigninTasks($lUser);

          if ($request->getParameter('do') == "signin") {
            $this->redirect("popup/add_service");
          } else {
            $this->redirect('@settings');
          }
        } else {
          $this->getUser()->setFlash('error', "EMAIL_NOT_VERIFIED");
          $this->redirect('@signin');
        }
      }
    }

    // if the second auth process isn't working, delete all sessions and
    // return an error
    if ($request->getParameter('do') == "signin") {
      // remove session and persistant variable
      PersistentVariablePeer::remove($this->getUser()->getAttribute('rpx_client', null, 'auth'));
      $this->getUser()->setAttribute('rpx_client', null, 'auth');
      $this->getUser()->setFlash("error", "Dieses ".$lRpxClient->getProvider()." Profil ist uns nicht bekannt.", true);
      $this->redirect("@signin");
    }

    $this->getUser()->setFlash('username', $lRpxClient->getUserObject()->getFullname());

    sfProjectConfiguration::getActive()->loadHelpers('I18N');
    $this->getUser()->setFlash('headline', __('WELCOME', null, 'widget'));

    $lPage = 'agb';
    $lCategory = 'rechtliches';

    try {
      $lCms = CmsPeer::getCmsByPageAndCategory($lPage, $lCategory);
      $this->headline = $lCms->getHeadline();
      $this->text = $lCms->getText();

    } catch (ModelException $e) {
      $this->forward404();
    }

    $lRpxClient->doPersist();
    $this->getUser()->setAttribute('rpx_client', $lRpxClient->getKey(), 'auth');
  }

  public function executeCreate_account(sfWebRequest $request) {
    $this->getResponse()->setSlot('js_document_ready', $this->getPartial('popup/js_popup_ready'));

    if ($this->getUser()->isAuthenticated()) {
      $this->redirect("@settings");
    }

    $lRpxClient = PersistentVariablePeer::get($this->getUser()->getAttribute('rpx_client', null, 'auth'));

    try {
      $lUser = $lRpxClient->doAutomatedSignupTasks();
      $this->getUser()->signIn($lUser);

      // remove session and persistant variable
      PersistentVariablePeer::remove($this->getUser()->getAttribute('rpx_client', null, 'auth'));
      $this->getUser()->setAttribute('rpx_client', null, 'auth');
    } catch (Exception $e) {
      $this->getUser()->setFlash("error", "REDUNDANT_ONLINE_IDENTITY", true);
      $this->redirect("@signin");
    }

    $this->redirect("@settings");
  }

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
      $checkedOnlineIdentities = $request->getParameter('enabled_services');
      OnlineIdentityPeer::toggleSocialPublishingStatus(UserIdentityConPeer::getOnlineIdentityIdsByUserId($this->getUser()->getId()), $checkedOnlineIdentities);

      $lTempData = YiidActivityPeer::getTemporaryData($_COOKIE["yiid_temp_hash"]);
      setcookie("yiid_temp_hash", '', time()-3600, '/', sfConfig::get('app_settings_host'));

      if ($lTempData) {
        $lStatus = YiidActivityPeer::saveLikeActivitys($this->getUser()->getId(),
                                            $lTempData["url"],
                                            UserIdentityConPeer::getOnlineIdentityIdsByUserId($this->getUser()->getId()),
                                            $this->getUser()->getUser()->getOiIdsForLikeWidget(),
                                            $lTempData["score"],
                                            $lTempData["verb"],
                                            $lTempData["title"],
                                            $lTempData["description"],
                                            $lTempData["photo"]);
      }

      $this->getUser()->setAttribute("yiid_temp_hash", null);

     $this->getUser()->setFlash("onload", "window.close();", false);
    }
    $this->pIdentities = $lUser->getOnlineIdentitiesForLikeWidget();

    CookieUtils::generateWidgetIdentityCookie($this->pIdentities);
    sfProjectConfiguration::getActive()->loadHelpers('I18N');
    $this->getUser()->setFlash('headline', __('SETTINGS', null, 'widget'));
    $this->setLayout('layout_twocol');
  }

  public function executeAdd_service(sfWebRequest $request) {
    $this->getResponse()->setSlot('js_document_ready', $this->getPartial('popup/js_popup_ready'));
    $lUser = $this->getUser()->getUser();

    if ($lToken = $request->getParameter('token')) {
      $lRpxClient = new RpxClient();
      $lRpxClient->authenticate($lToken);
    } else {
      $lRpxClient = PersistentVariablePeer::get($this->getUser()->getAttribute('rpx_client', null, 'auth'));
    }

    if ($lRpxClient) {
      try {
        sfContext::getInstance()->getLogger()->debug('{rpxOpenID}: RPX authentication');
        $lRpxClient->doSigninTasks($lUser, true);
        sfContext::getInstance()->getLogger()->debug('{rpxOpenID}: RPX signin');

        // remove session and persistant variable
        PersistentVariablePeer::remove($this->getUser()->getAttribute('rpx_client', null, 'auth'));
        $this->getUser()->setAttribute('rpx_client', null, 'auth');

        // update cookie
        CookieUtils::generateWidgetIdentityCookie($lUser->getOnlineIdentitiesForPublishing());
      } catch (Exception $e) {
        sfContext::getInstance()->getLogger()->err('{Exception}: '.$e->getMessage());
        $this->getUser()->setFlash('error', "PROFILE_ALREADY_CREATED");
      }
    }

    $this->redirect("@settings");
  }
}

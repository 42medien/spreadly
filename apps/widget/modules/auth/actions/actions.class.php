<?php

/**
 * auth actions.
 *
 * @package    yiid
 * @subpackage auth
 * @author     Matthias Pfefferle
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class authActions extends sfActions {

  public function initialize($context, $module, $action) {
    $parentRet = parent::initialize($context, $module, $action);

    // add context
    $this->pContext = $context->getRequest()->getParameter("widgetcontext", $context->getRequest()->getParameter('module'));

    sfConfig::set( 'app_twitter_oauth_callback_uri', '/widgets/'.$this->pContext.'/complete_signin/service/twitter' );
    sfConfig::set( 'app_facebook_oauth_callback_uri', '/widgets/'.$this->pContext.'/complete_signin/service/facebook' );

    return $parentRet;
  }

  /**
   * Executes index action
   *
   * @param sfRequest $request A request object
   */
  public function executeSignin(sfWebRequest $request) {
    $this->getResponse()->setSlot('js_document_ready', $this->getPartial('popup/js_popup_ready'));
    if ($this->getUser()->isAuthenticated()) {
      if ($this->pContext == "popup") {
        $this->redirect("@settings");
      } else {
        $this->redirect("@static_like");
      }
    }

    if ($this->pContext == "static") {
      $this->getUser()->setAttribute("redirect_after_login", $request->getUri(), "static_button");
    }

    sfProjectConfiguration::getActive()->loadHelpers('I18N');
    $this->getUser()->setFlash('headline', __('SETTINGS', null, 'widget'));
  }

  public function executeSignout(sfWebRequest $request) {
    $this->getUser()->signOut();
    $this->redirect('@'.$this->pContext.'_signin');
  }

  public function executeSigninto(sfWebRequest $request) {
    // if the user is already loged in, redirect to the stream
    if ($lService = $request->getParameter("service")) {
      $lObject = AuthApiFactory::factory($lService);
      $lObject->doAuthentication();
    } else {
      $this->redirect('@'.$this->pContext.'_signin');
    }
  }

  public function executeComplete_signin(sfWebRequest $request) {
    if ($lToken = $request->getParameter('oauth_token')) {
      $lToken = OauthRequestTokenTable::retrieveByTokenKey($lToken);
      $lToken = $lToken->toOAuthToken();
      $lToken->verifier = $request->getParameter('oauth_verifier');
    } elseif ($lToken = $request->getParameter('code')) {
      // do nothing
    }

    $lObject = AuthApiFactory::factory($request->getParameter('service'));

    // check if it is a signin/signup or if the user wants
    // to add a new online-identity
    if ($this->getUser()->isAuthenticated() && $this->getUser()->getUserId()) {
      try {
        $lObject->addIdentifier($this->getUser()->getUser(), $lToken);
      } catch (Exception $e) {
        $this->getUser()->setFlash("error", $e->getMessage(), true);
      }
    } else {
      $lUser = $lObject->doSignin($this->getUser(), $lToken);
      $this->getUser()->signIn($lUser);
      //UserRelationTable::doShit($lUser->getId());
    }
    $this->pOnlineIdenities = OnlineIdentityTable::getPublishingEnabledByUserId($this->getUser()->getUserId());
    CookieUtils::generateWidgetIdentityCookie($this->pOnlineIdenities);

    if ($this->pContext == "popup") {
      $this->redirect('@settings');
    } else {
      $lUrl = $this->getUser()->getAttribute("redirect_after_login", null, "static_button");
      $this->getUser()->setAttribute("redirect_after_login", null, "static_button");

      $this->redirect($lUrl);
    }
  }

  public function executeCreate_account(sfWebRequest $request) {

  }
}

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
  /**
   * Executes index action
   *
   * @param sfRequest $request A request object
   */
  public function executeSignin(sfWebRequest $request) {
    // cache get params
    if ($request->getParameter('url') != null) {
      $this->getUser()->setAttribute("redirect_after_login", $request->getUri(), "widget");
    }

    // check credentials
    $this->has_credentials = $this->getUser()->checkDealCredentials();

    // redirect if user is already logged in
    if ($this->getUser()->isAuthenticated() && $this->has_credentials) {
      $lUrl = $this->getUser()->getAttribute("redirect_after_login", "@widget_like", "widget");
      $this->redirect($lUrl);
    }

    sfProjectConfiguration::getActive()->loadHelpers('I18N');
    $this->getUser()->setFlash('headline', __('SETTINGS', null, 'widget'));
  }

  public function executeSignout(sfWebRequest $request) {
    $this->getUser()->signOut();
    $this->redirect('@signin');
  }

  public function executeSigninto(sfWebRequest $request) {
    // if the user is already loged in, redirect to the stream
    if ($lService = $request->getParameter("service")) {
      /*if ($request->hasParameter('r') && $request->getParameter('r') == "s") {
        $this->getUser()->setAttribute("redirect_after_login", "@widget_settings", "widget");
      }*/

      $lObject = AuthApiFactory::factory($lService);
      $lObject->doAuthentication();
    } else {
      $this->redirect('@signin');
    }
  }

  public function executeComplete_signin(sfWebRequest $request) {
    if ($lToken = $request->getParameter('oauth_token')) {
      $lToken = OauthRequestTokenTable::retrieveByTokenKey($lToken);
      $lToken = $lToken->toOAuthToken();
      $lToken->verifier = $request->getParameter('oauth_verifier');
    } elseif ($lToken = $request->getParameter('code')) {
      // do nothing
    } elseif ($request->getParameter('error') == "access_denied") {
      $this->redirect('@signin');
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
    }

    $lUrl = $this->getUser()->getAttribute("redirect_after_login", "@widget_like", "widget");

    $this->redirect($lUrl);
  }

  public function executeCreate_account(sfWebRequest $request) {

  }
}

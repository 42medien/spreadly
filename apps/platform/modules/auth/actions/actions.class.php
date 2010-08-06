<?php

/**
 * auth actions.
 *
 * @package    yiid
 * @subpackage auth
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class authActions extends sfActions {

  public function initialize($context, $module, $action) {
    $parentRet = parent::initialize($context, $module, $action);
    // if the user is already loged in, redirect to the stream
    if ($this->getUser()->isAuthenticated()) {
      $this->redirect("@stream");
    }
    return $parentRet;
  }

  public function executeSignin(sfWebRequest $request) {
    if ($lService = $request->getParameter("service")) {
      $lObject = AuthApiFactory::factory($lService);
      $lObject->doAuthentication();
    }
  }

  public function executeBasic(sfWebRequest $request) {
    if ($request->getMethod() == "POST") {
      // try to sign in the user
      try {
        // check if there is a matching user
        $lUser = UserTable::getByIdentifierAndPassword($request->getParameter('signin_user'), $request->getParameter('signin_password'));
        // try to sign in and redirect him to the stream
        $this->getUser()->signIn($lUser);
        UpdateUserRelationThread($lUser->getId());
        $this->redirect("@stream");
      } catch (Exception $e) {
        // catch the error and tell the user about it
        $this->getUser()->setFlash("error", $e->getMessage());
        $this->redirect("@homepage?auth=basic");
      }
    } else {
      $this->redirect("@homepage");
    }
  }

  public function executeComplete_twitter_signin(sfWebRequest $request) {
    $lRequestToken = OauthRequestTokenTable::retrieveByTokenKey($request->getParameter('oauth_token'));

    $lObject = AuthApiFactory::factory("twitter");
    $lUser = $lObject->doSignin($this->getUser(), $lRequestToken->toOAuthToken());

    $this->getUser()->signIn($lUser);
    UpdateUserRelationThread($lUser->getId());

    $this->redirect('@stream');
  }

  public function executeComplete_facebook_signin(sfWebRequest $request) {
    $lObject = AuthApiFactory::factory("facebook");
    $lUser = $lObject->doSignin($this->getUser(), $request->getParameter("code"));

    $this->getUser()->signIn($lUser);
    UpdateUserRelationThread($lUser->getId());

    $this->redirect('@stream');
  }

  public function executeRegistered(sfWebRequest $request) {

  }
}
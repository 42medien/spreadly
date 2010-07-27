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
      $lUser = UserTable::getByIdentifierAndPassword($request->getParameter('signin_user'), $request->getParameter('signin_password'));
      $this->getUser()->signIn($lUser);
      $this->redirect("@stream");
    }
  }

  public function executeComplete_signin(sfWebRequest $request) {
    $lRequestToken = OauthRequestTokenTable::retrieveByTokenKey($request->getParameter('oauth_token'));

    $lObject = AuthApiFactory::factory($lRequestToken->getCommunityId());
    $lObject->doSignin($this->getUser(), $lRequestToken->toOAuthToken());

    var_dump($lToken);exit;
  }
}
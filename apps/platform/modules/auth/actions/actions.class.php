<?php

/**
 * auth actions.
 *
 * @package    yiid
 * @subpackage auth
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class authActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request) {
    $this->forward('default', 'module');
  }

  public function executeSignin(sfWebRequest $request) {
    if ($lService = $request->getParameter("service")) {
      $lObject = AuthApiFactory::factory($lService);
      $lObject->doAuthentication();
    }

    $this->setLayout("plain");
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

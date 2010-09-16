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
    return $parentRet;
  }

  public function executeWidget_auth(sfWebRequest $request) {
    $lUrl = $request->getUri();

    $this->redirect(str_replace("www", "widgets", $lUrl));
  }

  public function executeSignin(sfWebRequest $request) {
    // if the user is already loged in, redirect to the stream
    if ($lService = $request->getParameter("service")) {
      $lObject = AuthApiFactory::factory($lService);
      $lObject->doAuthentication();
    } else {
      $this->redirect('@homepage');
    }
  }

  public function executeSignout(sfWebRequest $request) {
    if($this->getUser()->isAuthenticated()) {
      $this->getUser()->signOut();
    }
    $this->redirect('@homepage');
  }

  public function executeBasic(sfWebRequest $request) {
    if ($request->getMethod() == "POST") {
      // try to sign in the user
      try {
        // check if there is a matching user
        $lUser = UserTable::getByIdentifierAndPassword($request->getParameter('signin_user'), $request->getParameter('signin_password'));
        // try to sign in and redirect him to the stream
        $this->getUser()->signIn($lUser);

        // migrate if not already done
        if ($lUser->getDone() != 1) {
            UserRelationTable::doIdentityMigration($lUser->getId());
        }
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
    }

    // migrate if not already done
    if ($this->getUser()->getUser()->getDone() != 1) {
      UserRelationTable::doIdentityMigration($this->getUser()->getUserId());
    }
    $this->pOnlineIdenities = OnlineIdentityTable::getPublishingEnabledByUserId($this->getUser()->getUserId());
    CookieUtils::generateWidgetIdentityCookie($this->pOnlineIdenities);

    $this->redirect('@auth_add_services');
  }

  public function executeRegistered(sfWebRequest $request) {
    $this->pOnlineIdenities = OnlineIdentityTable::getPublishingEnabledByUserId($this->getUser()->getUserId());
    CookieUtils::generateWidgetIdentityCookie($this->pOnlineIdenities);
  }

  public function executeAdd_service(sfWebRequest $request) {

  }
}
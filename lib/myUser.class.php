<?php
/**
 *
 *  This class represents the "session user", which is not the same
 *  as the class User from the model.
 *
 *
 */
class myUser extends sfBasicSecurityUser {
  private $aUser = null;

  /**
   * returns the id from the session user
   *
   * @return int
   */
  public function getUserId() {
    return UserTable::retrieveByUsername('hugo')->getId();
    return $this->getAttribute('id', null, 'user_session');
  }

  /**
   * return user by session id
   *
   * @return User|null
   */
  public function getUser() {
    if ($this->isAuthenticated()) {
      if (!$this->aUser) {
        $this->aUser = UserTable::getInstance()->find($this->getUserId());
      }
      return $this->aUser;
    } else {
      return false;
    }
  }

  /**
   * clears the session user
   */
  public function signOut() {
    $this->clearCredentials();
  	$this->aUser = null;
  	$this->setAuthenticated(false);
  	$this->getAttributeHolder()->removeNamespace('user_session');
    $this->getAttributeHolder()->removeNamespace('login');
    $this->getAttributeHolder()->removeNamespace('network');

    CookieUtils::removeWidgetIdentityCookie();
    $this->setAttribute('Credcommunities', null );

    $this->setAttribute('TargetAfterLogin', null );
  	$this->shutdown();
  }

  /**
   * switch the language
   */
  public function switchLanguage($culture){
    $supported_cultures = LanguagePeer::getSupportedLanguages();

    if (in_array($culture, $supported_cultures)) {
      $this->setCulture($culture);
    } else {
      $this->setCulture(LanguagePeer::getDefaultLanguage());
    }

    $this->setAttribute('culture_set', true);
  }

  public function updateCulture() {
    $user = $this->getUser();
    $this->setCulture($user->getCulture());
  }


  /**
   * Sign in the user, and redirect afterwards to index or
   * OpenId Trust Screen
   *
   * @param User $pUser
   * @param sfActions $pCaller The calling action
   */
  public function signInAndRedirect( User $pUser, sfActions $pCaller, $openIdReferer = null ){
  	$this->signIn( $pUser );

  	$lRemReq = $this->getAttribute('RedirectToReferer');
    $this->setAttribute('RedirectToReferer', null );

  	$lRemReq = $this->getAttribute('TargetAfterLogin', $lRemReq);
    $this->setAttribute('TargetAfterLogin', null );

    // check auth completion
  	$lPersistent = PersistentObjectPeer::get($pUser->getId(), 'auth_completion');
  	if ($lPersistent && $lPersistent == "show") {
  	  $lRemReq = 'dashboard/magic';
  	}

    if( $lRemReq ){
    	$this->setFlash('redirectfromlogin', true);
      $pCaller->redirect( $lRemReq );
    } else {
	    if(!$openIdReferer)
	    	$referer = sfContext::getInstance()->getRequest()->getReferer();
	    else
	    	$referer = $openIdReferer;

	    $yiidDomain = preg_match('/yiid/', parse_url($referer, PHP_URL_HOST));
	    $communipediaDomain = preg_match('/communipedia/', parse_url($referer, PHP_URL_HOST));

	    if($yiidDomain == 1 || $communipediaDomain == 1)
	     	$domainIsValid = true;
	    else
	      $domainIsValid = false;

	    $auth = preg_match('/auth/', $referer);

	    // for security reasons remove complete loginstatus namespace
	    $this->setAttribute('referer', null, 'login');
      sfContext::getInstance()->getUser()->getAttributeHolder()->removeNamespace('login');

      if(!$auth && $domainIsValid) {
	    	$pCaller->redirect($referer);
	    } else {
	    	$pCaller->redirect('dashboard/index');
	    }
    }
  }

  /**
   * This method sets the redirection url after login into the session
   *
   */
  public function setRedirectUrl( $request ) {
  	if ($request->getParameter('module') == "auth") {
      $uri = $request->getReferer();
      $domain = UrlUtils::getDomain($uri);
  	} else {
  	  $uri = $request->getUri();
      // get refered URL
      $domain = $_SERVER['SERVER_NAME'];
  	}

    $yiidDomain = preg_match('/yiid/', $domain);
    $communipediaDomain = preg_match('/communipedia/', $domain);
    if($yiidDomain == 1 || $communipediaDomain == 1)
    	$domainIsValid = true;
    else
    	$domainIsValid = false;

    $lPregMatch = "~".preg_quote(sfConfig::get("app_settings_url")."/auth")."~";

    if(!preg_match($lPregMatch, $uri) && $domainIsValid) {
    	$this->setAttribute('RedirectToReferer', $uri);
    }
  }

  /**
   * sign in a user (from Model) in as session user
   *
   * @param User $user
   */
  public function signIn( User $user ) {
    // set the usersession
    $this->setAttribute('id', $user->getId(), 'user_session');
    $lCredentials = explode( ',', $user->getCredentials() );
    if( count($lCredentials) != 0 ) $this->addCredentials( $lCredentials );
    $lCredcommunities = explode( ',', $user->getCredcommunities() );
    $this->setAttribute( "Credcommunities", $lCredcommunities );
    $this->setAuthenticated(true);
    $this->switchLanguage($user->getCulture());

    CookieUtils::generateWidgetIdentityCookie($user->getOnlineIdentitiesForLikeWidget());

    // if user is translator and wants to translate site, store this in session
    if($this->hasCredential(array('translator'), false)) {
      $lTranslationSystemStatus = SettingPeer::getSettingForUser($user->getId(), 'setting', SettingPeer::SETTING_TRANSLATION_ENABLED);
	    if(!$lTranslationSystemStatus || $lTranslationSystemStatus->getValue() == 0) {
	      $this->setAttribute( "display_translation_system", false);
	    } else {
	      $this->setAttribute( "display_translation_system", true);
	    }
    }

    // save login time in user_last_login
    $lTimestamp = time();
    $lUserLastLogin = UserLastLoginPeer::retrieveByUserId($user->getId());
    if(!$lUserLastLogin) {
      $lUserLastLogin = new UserLastLogin();
      $lUserLastLogin->setUserId($user->getId());
      $lUserLastLogin->setLastLogin($lTimestamp);
      $lUserLastLogin->setCurrentLogin($lTimestamp);
    } else {
	    $lUserLastLogin->setLastLogin($lUserLastLogin->getCurrentLogin());
	    $lUserLastLogin->setCurrentLogin($lTimestamp);
    }
    $lUserLastLogin->save();
  }

  /**
   * remember a target ot redirect the user after the next
   * successful login
   * @param  sfWebRequest $pRequest
   */
  public function setRedirectAfterNextLogin( $pRedirect ){
  	$this->setAttribute( 'TargetAfterLogin', $pRedirect );
  }

  /**
   * generates a random key for...
   *
   * @param int $len
   * @return string
   */
  protected function generateRandomKey($len = 20) {
    $string = '';
    $pool = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

    for ($i = 1; $i <= $len; $i++) {
      $string .= substr($pool, rand(0, 61), 1);
    }

    return md5($string);
  }

  /**
   * returns the short culture code
   *
   * @return string
   */
  public function getShortedCulture() {
    $culture = $this->getCulture();

    return substr($culture, 0, 2);
  }
}
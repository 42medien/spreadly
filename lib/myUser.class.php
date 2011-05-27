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
    return $this->getAttribute('id', null, 'user_session');
  }

  /** wrapper for getUserId()..
   *
   * Enter description here ...
   */
  public function getId() {
    return $this->getUserId();
  }

  /**
   * return user by session id
   *
   * @return User|null
   */
  public function getUser() {
    if ($this->isAuthenticated()) {
      if (!$this->aUser) {
        $this->aUser = UserTable::getInstance()->retrieveByPk($this->getUserId());
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
    $supported_cultures = LanguageTable::getAllLanguageCodesAsArray(true);

    if (in_array($culture, $supported_cultures)) {
      $this->setCulture($culture);
    } else {
      $this->setCulture(LanguageTable::getDefaultLanguage());
    }

    $this->setAttribute('culture_set', true);
  }

  public function updateCulture() {
    $user = $this->getUser();
    $this->setCulture($user->getCulture());
  }

  /**
   * sign in a user (from Model) in as session user
   *
   * @param User $user
   */
  public function signIn( $user ) {
    $this->clearCredentials();
    // set the usersession
    $this->setAttribute('id', $user->getId(), 'user_session');
    $this->setAuthenticated(true);
    $lCredentials = explode( ',', $user->getCredentials() );
    if( count($lCredentials) != 0 ) $this->addCredentials( $lCredentials );
    //$this->switchLanguage($user->getCulture());
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

  public function checkDealCredentials() {
    $user = $this->getUser();

    // check url param
    $url = sfContext::getInstance()->getRequest()->getParameter("url", null);
    $tags = sfContext::getInstance()->getRequest()->getParameter("tags", null);

    // check user session
    if ((!$url || !$tags) && $redirect_url = $this->getAttribute("redirect_after_login", null, "widget")) {
      $params = explode("?", $redirect_url);
      parse_str($params[1]);
    }

    if ($user) {
      // if there is an url and a user
      if ($url && $deal = DealTable::getActiveDealByHostAndUserId($url, $user->getId(), $tags)) {
        if (!$deal->hasUserTheRequiredCredentials($user)) {
          return false;
        }
      }
    }

    $deal = DealTable::getActiveByHost($url, $tags);

    if ($deal && $deal->getCouponType() == "html") {
      return false;
    }

    return true;
  }
}
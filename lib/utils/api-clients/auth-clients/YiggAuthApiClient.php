<?php
/**
 * Enter description here...
 *
 * @author Matthias Pfefferle
 */
class YiggAuthApiClient extends AuthApi {

  protected $aCommunity = "yigg";

  /**
   * start the sign in process
   *
   * @author Matthias Pfefferle
   * @param myUser $pSessionUser
   * @param AuthToken $pAuthToken
   */
  public function doSignin($pSessionUser, $pOAuthToken) {
    $lAccessToken = $this->getAccessToken($pOAuthToken);

    $lParams = $lAccessToken->params;
    $lParamsArray = array();
    // extract params
    parse_str($lParams, $lParamsArray);

    // get api informations
    $lJson = OAuthClient::get($this->getConsumer(), $lParamsArray['oauth_token'], $lParamsArray['oauth_token_secret'], "http://api.yigg.local/profiles/me");
    $lJsonObject = json_decode($lJson);

    sfContext::getInstance()->getLogger()->notice("API response" . print_r($lJsonObject, true));

    // ask for online identity
    $lOnlineIdentity = OnlineIdentityTable::retrieveByOriginalId($lJsonObject->id, $this->aCommunityId);

    // check if user already exists
    if ($lOnlineIdentity) {
      $lUser = $lOnlineIdentity->getUser();
    } else {
      // get auth identifier
      foreach ($lJsonObject->urls as $url) {
        if ($url->type == "profile") {
          $lIdentifier = $url->value;
        }
      }

      // check online identity
      $lOnlineIdentity = OnlineIdentityTable::addOnlineIdentity($lIdentifier, $lJsonObject->id, $this->aCommunityId);

      // if there is no online identity die!
      if (!$lOnlineIdentity) {
        throw new sfException("incorrect online identity", 3);
      }

      // generate empty user
      $lUser = new User();
    }

    if (!$lUser || !$lUser->getId() || !$lOnlineIdentity->getPhoto()) {
      // use api complete informations
      $this->completeUser($lUser, $lJsonObject);
      $this->completeOnlineIdentity($lOnlineIdentity, $lJsonObject, $lUser, $lIdentifier);
    }

    // save new token
    AuthTokenTable::saveToken($lUser->getId(), $lOnlineIdentity->getId(), $lParamsArray['oauth_token'], $lParamsArray['oauth_token_secret'], true);

    return $lUser;
  }

  /**
   * add identifier
   *
   * @author Matthias Pfefferle
   * @param User $pUser
   * @param AuthToken $pAuthToken
   * @return OnlineIdentity
   */
  public function addIdentifier($pUser, $pOAuthToken) {
    $lAccessToken = $this->getAccessToken($pOAuthToken);

    // get api informations
    $lJson = OAuthClient::get($this->getConsumer(), $lParamsArray['oauth_token'], $lParamsArray['oauth_token_secret'], "http://api.yigg.local/profiles/me");
    $lJsonObject = json_decode($lJson);

    // ask for online identity
    $lOnlineIdentity = OnlineIdentityTable::retrieveByOriginalId($lJsonObject->id, $this->aCommunityId);

    // check if user already exists
    if ($lOnlineIdentity) {
      if ($lOnlineIdentity->getUserId() && ($pUser->getId() == $lOnlineIdentity->getUserId())) {
        if (!$lOnlineIdentity->getActive()) {
          $lOnlineIdentity->setActive(true);
        } else {
          throw new sfException("online identity already added", 1);
        }
      } elseif ($lOnlineIdentity->getUserId() && ($pUser->getId() != $lOnlineIdentity->getUserId())) {
        throw new sfException("online identity already added by someone else", 2);
      }
    } else {
      // get auth identifier
      foreach ($lJsonObject->urls as $url) {
        if ($url['type'] == "profile") {
          $lIdentifier = $url['value'];
        }
      }

      // check online identity
      $lOnlineIdentity = OnlineIdentityTable::addOnlineIdentity($lIdentifier, $lJsonObject->id, $this->aCommunityId);
    }

    $this->completeOnlineIdentity($lOnlineIdentity, $lJsonObject, $pUser, $lIdentifier);

    AuthTokenTable::saveToken($pUser->getId(), $lOnlineIdentity->getId(), $lParamsArray['oauth_token'], $lParamsArray['oauth_token_secret'], true);

    return $lOnlineIdentity;
  }

  /**
   * ask twitter for an access-key
   *
   * @author Matthias Pfefferle
   * @return OAuthToken
   */
  public function getRequestToken() {
    $lRequestToken = OAuthClient::getRequestToken($this->getConsumer(), "http://api.yigg.local/oauth/1/request", 'GET', array("oauth_callback" => $this->getCallbackUri()));

    sfContext::getInstance()->getLogger()->debug(print_r($lRequestToken, true));

    // save the request token
    OauthRequestTokenTable::saveToken($lRequestToken, $this->getCommunity());

    return $lRequestToken;
  }

  /**
   * do the athentication on twitter and redirect to twitter
   *
   * @author Matthias Pfefferle
   * @link http://dev.twitter.com/pages/sign_in_with_twitter
   */
  public function doAuthentication() {
    $lRequestToken = self::getRequestToken();
    $lRequest = OAuthClient::prepareRequest($this->getConsumer(), $lRequestToken, "GET", "http://api.yigg.local/oauth/1/authorize");
    // redirect
    header("Location: " . $lRequest->to_url());
    // do nothing more
    exit;
  }

  /**
   * ask twitter for an access token
   *
   * @author Matthias Pfefferle
   * @param string $pTokenKey
   */
  public function getAccessToken($pOAuthToken) {
    $lAccessToken = OAuthClient::getAccessToken($this->getConsumer(), "http://api.yigg.local/oauth/1/access", $pOAuthToken, "GET", array("oauth_verifier" => $pOAuthToken->verifier));

    return $lAccessToken;
  }

  /**
   * complete the user with the api json
   *
   * @param User $pUser
   * @param Object $pObject
   */
  public function completeUser(&$pUser, $pObject) {
    $pUser->setUsername(UserUtils::getUniqueUsername(StringUtils::normalizeUsername($pObject->nickname)));
    if (isset($pObject->note) && !$pUser->getDescription()) {
      $pUser->setDescription(strip_tags($pObject->note));
    }

    if (isset($pObject->birthday)) {
      $pUser->setBirthdate($pObject->birthday);
    }

    $pUser->setActive(true);
    $pUser->setAgb(true);

    $pUser->setCulture("de");
    $pUser->save();
  }

  /**
   * complete the online-identity with the api json
   *
   * @param OnlineIdentity $pOnlineIdentity
   * @param Object $pObject
   */
  public function completeOnlineIdentity(&$pOnlineIdentity, $pObject, $pUser, $pAuthIdentifier) {
    $pOnlineIdentity->setUserId($pUser->getId());
    $pOnlineIdentity->setAuthIdentifier($pAuthIdentifier);
    $pOnlineIdentity->setSocialPublishingEnabled(true);
    $pOnlineIdentity->setName($pObject->nickname);

    $pOnlineIdentity->setProfileUri($pAuthIdentifier);

    if (isset($pObject->gender)) {
      $pOnlineIdentity->setGender($pObject->gender);
    }

    if (isset($pObject->birthday)) {
      $pOnlineIdentity->setBirthdate($pObject->birthday);
    }

    $pOnlineIdentity->save();
  }
}
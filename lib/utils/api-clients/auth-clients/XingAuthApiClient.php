<?php
/**
 * Enter description here...
 *
 * @author Matthias Pfefferle
 */
class XingAuthApiClient extends AuthApi {

  protected $aCommunity = "xing";

  /**
   * start the sign in process
   *
   * @author Matthias Pfefferle
   * @param myUser $pSessionUser
   * @param AuthToken $pAuthToken
   */
  public function doSignin($pSessionUser, $pOAuthToken) {
    $lAccessToken = $this->getAccessToken($pOAuthToken);
    //var_dump($lAccessToken);die();
    // get params
    $lParams = $lAccessToken->params;
    $lParamsArray = array();
    // extract params
    parse_str($lParams, $lParamsArray);

    $json = OAuthClient::get($this->getConsumer(), $lParamsArray['oauth_token'], $lParamsArray['oauth_token_secret'], "https://api.xing.com/v1/users/me.json");

    $json = json_decode($json, true);

    $xing_user = $json['users'][0];
    $auth_identifier = $xing_user["permalink"];

    // ask for online identity
    $online_identity = OnlineIdentityTable::retrieveByOriginalId($xing_user['id']);

    // check if user already exists
    if ($online_identity) {
      $user = $online_identity->getUser();
    } else {
      // check online identity
      $online_identity = OnlineIdentityTable::addOnlineIdentity($auth_identifier, $xing_user['id'], $this->aCommunityId);

      // if there is no online identity die!
      if (!$online_identity) {
        throw new sfException("incorrect online identity", 3);
      }

      // generate empty user
      $user = new User();
    }

    if (!$user || !$user->getId() || !$online_identity->getPhoto()) {
      // use api complete informations
      $this->completeUser($user, $xing_user);
      $this->completeOnlineIdentity($online_identity, $xing_user, $user, $auth_identifier);
    }

    // save new token
    AuthTokenTable::saveToken($user->getId(), $online_identity->getId(), $lParamsArray['oauth_token'], $lParamsArray['oauth_token_secret'], true);

    return $user;
  }

  /**
   * add identifier
   *
   * @author Matthias Pfefferle
   * @param User $pUser
   * @param AuthToken $pAuthToken
   * @return OnlineIdentity
   */
  public function addIdentifier($user, $pOAuthToken) {
    $lAccessToken = $this->getAccessToken($pOAuthToken);

    // get params
    $lParams = $lAccessToken->params;
    $lParamsArray = array();
    // extract params
    parse_str($lParams, $lParamsArray);

    $json = OAuthClient::get($this->getConsumer(), $lParamsArray['oauth_token'], $lParamsArray['oauth_token_secret'], "https://api.xing.com/v1/users/me");
    $json = json_decode($json, true);

    $xing_user = $json['users'][0];
    $auth_identifier = $xing_user["permalink"];

    // ask for online identity
    $online_identity = OnlineIdentityTable::retrieveByOriginalId($xing_user['id']);

    // check if user already exists
    if ($online_identity) {
      if ($online_identity->getUserId() && ($user->getId() == $online_identity->getUserId())) {
        if (!$online_identity->getActive()) {
          $online_identity->setActive(true);
        } else {
          throw new sfException("online identity already added", 1);
        }
      } elseif ($online_identity->getUserId() && ($user->getId() != $online_identity->getUserId())) {
        throw new sfException("online identity already added by someone else", 2);
      }
    } else {
      // check online identity
      $online_identity = OnlineIdentityTable::addOnlineIdentity($auth_identifier, $xing_user['id'], $this->aCommunityId);
    }

    $this->completeOnlineIdentity($online_identity, $xing_user, $user, $auth_identifier);

    // save new token
    AuthTokenTable::saveToken($user->getId(), $online_identity->getId(), $lParamsArray['oauth_token'], $lParamsArray['oauth_token_secret'], true);

    return $user;
  }

  /**
   * ask twitter for an access-key
   *
   * @author Matthias Pfefferle
   * @return OAuthToken
   */
  public function getRequestToken() {
    $lRequestToken = OAuthClient::getRequestToken($this->getConsumer(), "https://api.xing.com/v1/request_token", 'POST', array("oauth_callback" => $this->getCallbackUri()));
    
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
    $lRequest = OAuthClient::prepareRequest($this->getConsumer(), $lRequestToken, "GET", "https://api.xing.com/v1/authorize");
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
    $lAccessToken = OAuthClient::getAccessToken($this->getConsumer(), "https://api.xing.com/v1/access_token", $pOAuthToken, "POST", array("oauth_verifier" => $pOAuthToken->verifier));

    return $lAccessToken;
  }

  /**
   * complete the user with the api json
   *
   * @param User $pUser
   * @param Object $pObject
   */
  public function completeUser(&$pUser, $pObject) {
    $pUser->setUsername(UserUtils::getUniqueUsername(StringUtils::normalizeUsername($pObject["page_name"])));
    $pUser->setActive(true);
    $pUser->setAgb(true);
    $pUser->setFirstname($pObject['first_name']);
    $pUser->setFirstname($pObject['last_name']);
    $pUser->setEmail($pObject['active_email']);

    $pUser->save();
  }

  /**
   * complete the online-identity with the api json
   *
   * @param OnlineIdentity $pOnlineIdentity
   * @param Object $pObject
   */
  public function completeOnlineIdentity(&$pOnlineIdentity, $pObject, $pUser, $pAuthIdentifier) {
    // delegate to ImportClient to avoid duplicate code
    /* signup,add new */
    $pOnlineIdentity->setUserId($pUser->getId());
    $pOnlineIdentity->setAuthIdentifier($pAuthIdentifier);
    $pOnlineIdentity->setName($pObject['display_name']);
    $pOnlineIdentity->setGender($pObject['gender']);

    // transform facebook format into
    $pOnlineIdentity->setBirthdate($pObject['birth_date']['year'].'-'.$pObject['birth_date']['month'].'-'.$pObject['birth_date']['day']);
    $pOnlineIdentity->setSocialPublishingEnabled(true);
    $pOnlineIdentity->setLocationRaw($pObject["business_address"]["city"]);
    $pOnlineIdentity->setPhoto($pObject["photo_urls"]["large"]);

    $pOnlineIdentity->save();

    $pUser->setRelationshipState($pOnlineIdentity->getRelationshipState());
    $pUser->setBirthdate($pOnlineIdentity->getBirthDate());
    $pUser->save();
  }
}
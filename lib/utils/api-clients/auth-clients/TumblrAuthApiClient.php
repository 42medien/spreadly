<?php
/**
 * Enter description here...
 *
 * @author Matthias Pfefferle
 */
class TumblrAuthApiClient extends AuthApi {

  protected $aCommunity = "tumblr";

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
    //$lConsumer = new OAuthConsumer(sfConfig::get("app_linkedin_oauth_token"), sfConfig::get("app_linkedin_oauth_secret"));


    $json = OAuthClient::post($this->getConsumer(), $lParamsArray['oauth_token'], $lParamsArray['oauth_token_secret'], "http://api.tumblr.com/v2/user/info");
    $json = json_decode($json, true);

    $user_name = $json['response']['user']['name'];
    $auth_identifier = "http://".$user_name.".tumblr.com";

    // ask for online identity
    $online_identity = OnlineIdentityTable::retrieveByAuthIdentifier($auth_identifier);

    // check if user already exists
    if ($online_identity) {
      $user = $online_identity->getUser();
    } else {
      // check online identity
      $online_identity = OnlineIdentityTable::addOnlineIdentity($auth_identifier, $user_name, $this->aCommunityId);

      // if there is no online identity die!
      if (!$online_identity) {
        throw new sfException("incorrect online identity", 3);
      }

      // generate empty user
      $user = new User();
    }

    if (!$user || !$user->getId() || !$online_identity->getPhoto()) {
      // use api complete informations
      $this->completeUser($user, $json['response']);
      $this->completeOnlineIdentity($online_identity, $json['response'], $user, $auth_identifier);
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
    //var_dump($lAccessToken);die();
    // get params
    $lParams = $lAccessToken->params;
    $lParamsArray = array();
    // extract params
    parse_str($lParams, $lParamsArray);
    //$lConsumer = new OAuthConsumer(sfConfig::get("app_linkedin_oauth_token"), sfConfig::get("app_linkedin_oauth_secret"));


    $json = OAuthClient::post($this->getConsumer(), $lParamsArray['oauth_token'], $lParamsArray['oauth_token_secret'], "http://api.tumblr.com/v2/user/info");
    $json = json_decode($json, true);

    $user_name = $json['response']['user']['name'];
    $auth_identifier = "http://".$user_name.".tumblr.com";

    // ask for online identity
    $online_identity = OnlineIdentityTable::retrieveByAuthIdentifier($auth_identifier);

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
      $online_identity = OnlineIdentityTable::addOnlineIdentity($auth_identifier, $user_name, $this->aCommunityId);
    }

    $this->completeOnlineIdentity($online_identity, $json['response'], $user, $auth_identifier);

    // save new token
    AuthTokenTable::saveToken($user->getId(), $online_identity->getId(), $lParamsArray['oauth_token'], $lParamsArray['oauth_token_secret'], true);

    return $user;
  }

  /**
   * ask tumblr for an access-key
   *
   * @author Matthias Pfefferle
   * @return OAuthToken
   */
  public function getRequestToken() {
    $lRequestToken = OAuthClient::getRequestToken($this->getConsumer(), "http://www.tumblr.com/oauth/request_token", 'GET', array("oauth_callback" => $this->getCallbackUri()));

    // save the request token
    OauthRequestTokenTable::saveToken($lRequestToken, $this->getCommunity());

    return $lRequestToken;
  }

  /**
   * do the athentication on tumblr and redirect to tumblr
   *
   * @author Matthias Pfefferle
   * @link http://dev.twitter.com/pages/sign_in_with_twitter
   */
  public function doAuthentication() {
    $lRequestToken = self::getRequestToken();
    $lRequest = OAuthClient::prepareRequest($this->getConsumer(), $lRequestToken, "GET", "http://www.tumblr.com/oauth/authorize");
    // redirect
    header("Location: " . $lRequest->to_url());
    // do nothing more
    exit;
  }

  /**
   * ask tumblr for an access token
   *
   * @author Matthias Pfefferle
   * @param string $pTokenKey
   */
  public function getAccessToken($pOAuthToken) {
    $lAccessToken = OAuthClient::getAccessToken($this->getConsumer(), "http://www.tumblr.com/oauth/access_token", $pOAuthToken, "GET", array("oauth_verifier" => $pOAuthToken->verifier));

    return $lAccessToken;
  }

  /**
   * complete the user with the api json
   *
   * @param User $pUser
   * @param Object $pObject
   */
  public function completeUser(&$pUser, $pObject) {
    $pUser->setUsername(UserUtils::getUniqueUsername(StringUtils::normalizeUsername($pObject['user']['name'])));
    $pUser->setActive(true);
    $pUser->setAgb(true);

    // try to split full-name
    $lName = MicroformatsTools::splitFN($pObject['user']['name']);
    if (array_key_exists("firstname", $lName)) {
      $pUser->setFirstname($lName['firstname']);
    }
    if (array_key_exists("lastname", $lName)) {
      $pUser->setFirstname($lName['lastname']);
    }

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
    $pOnlineIdentity->setSocialPublishingEnabled(false);
    $pOnlineIdentity->setName($pObject['user']['name']);
    $pOnlineIdentity->save();
  }
}
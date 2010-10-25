<?php
/**
 * Enter description here...
 *
 * @author Matthias Pfefferle
 */
class GoogleAuthApiClient extends AuthApi {

  protected $aCommunity = "google";

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


    $lJson = OAuthClient::get($this->getConsumer(), $lParamsArray['oauth_token'], $lParamsArray['oauth_token_secret'], "https://www.googleapis.com/buzz/v1/people/@me/@self?alt=json");

    $lObject = json_decode($lJson);
    $lObject = $lObject->data;

    $lProfileUri = "http://www.google.com/profiles/pfefferle";
    $lAuthIdentifier = "http://www.google.com/profiles/pfefferle";

    // ask for online identity
    $lOnlineIdentity = OnlineIdentityTable::retrieveByAuthIdentifier($lAuthIdentifier);

    // check if user already exists
    if ($lOnlineIdentity) {
      $lUser = $lOnlineIdentity->getUser();
    } else {

      // check online identity
      try {
        $lOnlineIdentity = OnlineIdentityTable::addOnlineIdentity($lProfileUri, $lObject->id, $this->aCommunityId, $lAuthIdentifier);
      } catch (Exception $e) {}
      // generate empty user
      $lUser = new User();
    }

    if (!$lUser || !$lUser->getId()) {
      $this->completeUser($lUser, $lObject);
    	$this->completeOnlineIdentity($lOnlineIdentity, $lObject, $lUser, $lAuthIdentifier);
    }

    // import contacts
    //$this->importContacts($lOnlineIdentity->getId());

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
    //var_dump($lAccessToken);die();
    // get params
    $lParams = $lAccessToken->params;
    $lParamsArray = array();
    // extract params
    parse_str($lParams, $lParamsArray);
    //$lConsumer = new OAuthConsumer(sfConfig::get("app_linkedin_oauth_token"), sfConfig::get("app_linkedin_oauth_secret"));


    $lJson = OAuthClient::get($this->getConsumer(), $lParamsArray['oauth_token'], $lParamsArray['oauth_token_secret'], "https://www.googleapis.com/buzz/v1/people/@me/@self?alt=json");

    $lObject = json_decode($lJson);
    $lObject = $lObject->data;

    $lProfileUri = "http://www.google.com/profiles/pfefferle";
    $lAuthIdentifier = "http://www.google.com/profiles/pfefferle";

    // ask for online identity
    $lOnlineIdentity = OnlineIdentityTable::retrieveByAuthIdentifier($lAuthIdentifier);

    // check if user already exists
    if ($lOnlineIdentity) {
      if ($lOnlineIdentity->getUserId() && ($pUser->getId() == $lOnlineIdentity->getUserId())) {
        throw new sfException("online identity already added by you", 1);
      } elseif ($lOnlineIdentity->getUserId() && ($pUser->getId() != $lOnlineIdentity->getUserId())) {
        throw new sfException("online identity already added by someone else", 2);
      }
    } else {
      // new online identity if no exist
      $lOnlineIdentity = OnlineIdentityTable::addOnlineIdentity($lProfileUri, $lObject->id, $this->aCommunityId, $lProfileUri);
    }

    $this->completeOnlineIdentity($lOnlineIdentity, $lObject, $lUser, $lAuthIdentifier);

    AuthTokenTable::saveToken($pUser->getId(), $lOnlineIdentity->getId(), $lParamsArray['oauth_token'], $lParamsArray['oauth_token_secret'], true);

    return $lOnlineIdentity;
  }

  /**
   * ask linkedin for an access-key
   *
   * @author Matthias Pfefferle
   * @return OAuthToken
   */
  public function getRequestToken() {
    $lRequestToken = OAuthClient::getRequestToken($this->getConsumer(), "https://www.google.com/accounts/OAuthGetRequestToken", 'GET', array("oauth_callback" => $this->getCallbackUri(), "scope" => "https://www.googleapis.com/auth/buzz"));

    // save the request token
    OauthRequestTokenTable::saveToken($lRequestToken, $this->getCommunity());

    return $lRequestToken;
  }

  /**
   * do the athentication on linkedin and redirect to linkedin
   *
   * @author Matthias Pfefferle
   * @link https://www.linkedin.com/uas/oauth/authenticate
   */
  public function doAuthentication() {
    $lRequestToken = self::getRequestToken();
    $lRequest = OAuthClient::prepareRequest($this->getConsumer(), $lRequestToken, "GET", "https://www.google.com/buzz/api/auth/OAuthAuthorizeToken", array("domain" => "www.yiid.com", "scope" => "https://www.googleapis.com/auth/buzz"));
    // redirect
    header("Location: " . $lRequest->to_url());
    // do nothing more
    exit;
  }

  /**
   * ask linkedin for an access token
   *
   * @author Matthias Pfefferle
   * @param string $pTokenKey
   */
  public function getAccessToken($pOAuthToken) {
    $lAccessToken = OAuthClient::getAccessToken($this->getConsumer(), "https://www.google.com/accounts/OAuthGetAccessToken", $pOAuthToken, "GET", array("oauth_verifier" => $pOAuthToken->verifier, "scope" => "https://www.googleapis.com/auth/buzz"));

    return $lAccessToken;
  }

  /**
   * complete the user with the api json
   *
   * @param User $pUser
   * @param Object $pObject
   */
  public function completeUser(&$pUser, $pObject) {
    $pUser->setUsername(UserUtils::getUniqueUsername(StringUtils::normalizeUsername($pObject->displayName)));
    $pUser->setDescription(@$pObject->aboutMe);

    // try to split full-name
    $lName = MicroformatsTools::splitFN($pObject->displayName);
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
   * @author Matthias Pfefferle
   * @param OnlineIdentity $pOnlineIdentity
   * @param Object $pObject
   */
  public function completeOnlineIdentity(&$pOnlineIdentity, $pObject, $pUser, $pAuthIdentifier) {
    $pOnlineIdentity->setName($pObject->displayName);
    //$pOnlineIdentity->setPhoto($pObject->profile_image_url);
    $pOnlineIdentity->setSocialPublishingEnabled(true);

    $pOnlineIdentity->setUserId($pUser->getId());                  /* signup,add new */
    $pOnlineIdentity->setAuthIdentifier($pAuthIdentifier);
    $pOnlineIdentity->save();

    $this->importContacts($pOnlineIdentity->getId());

    $lImgPath = $pObject->thumbnailUrl;
    $lPayload = serialize(array('path' => $lImgPath, 'user_id' => $pUser->getId(), 'oi_id' => $pOnlineIdentity->getId()));
    AmazonSQSUtils::pushToQuque('ImageImport', $lPayload);
  }
}
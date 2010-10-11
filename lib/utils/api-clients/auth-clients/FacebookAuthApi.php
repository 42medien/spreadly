<?php
/**
 * Enter description here...
 *
 * @author Matthias Pfefferle
 */
class FacebookAuthApiClient extends AuthApi {

  protected $aCommunity = "facebook";

  /**
   * generates a OAuthConsumer
   *
   * @author Matthias Pfefferle
   * @return OAuthConsumer
   */
  public function getConsumer() {
    $lConsumer = new OAuthConsumer(sfConfig::get("app_facebook_oauth_token"), sfConfig::get("app_facebook_oauth_secret"));

    return $lConsumer;
  }

  /**
   * start the sign in process
   *
   * @author Matthias Pfefferle
   * @param myUser $pSessionUser
   * @param AuthToken $pAuthToken
   */
  public function doSignin($pSessionUser, $pCode) {
    $lAccessToken = $this->getAccessToken($pCode);

    // get params
    $lParamsArray = array();
    // extract params
    parse_str($lAccessToken, $lParamsArray);

    $lJsonObject = json_decode(UrlUtils::sendGetRequest("https://graph.facebook.com/me?access_token=".$lParamsArray['access_token']));

    // facebook identifier
    $lIdentifier = "http://www.facebook.com/profile.php?id=".$lJsonObject->id;

    // ask for online identity
    $lOnlineIdentity = OnlineIdentityTable::retrieveByAuthIdentifier($lIdentifier);

    // check if user already exists
    if ($lOnlineIdentity) {
      $lUser = $lOnlineIdentity->getUser();
    } else {
      // check online identity
      $lOnlineIdentity = OnlineIdentityTable::addOnlineIdentity($lJsonObject->link, $this->aCommunityId);
      // generate empty user
      $lUser = new User();
    }

    // if there is no user create one
    if (!$lUser || !$lUser->getId()) {
      // @todo <todo> encapsulating this
      // use api complete informations
      $this->completeOnlineIdentity($lOnlineIdentity, $lJsonObject); // signup,add new
      $this->completeUser($lUser, $lJsonObject);                     // signup

      $lOnlineIdentity->setUserId($lUser->getId());                  /* signup,add new */
      $lOnlineIdentity->setAuthIdentifier($lIdentifier);
      $lOnlineIdentity->save();

      // delete connected user-cons
      UserIdentityConTable::deleteAllConnections($lOnlineIdentity->getId());  // signup,add new

      $lUserIdentityCon = new UserIdentityCon();                     /* signup,add new */
      $lUserIdentityCon->setUserId($lUser->getId());
      $lUserIdentityCon->setOnlineIdentityId($lOnlineIdentity->getId());
      $lUserIdentityCon->setVerified(true);
      $lUserIdentityCon->save();
      // </todo>

      $lImgPath = "https://graph.facebook.com/".$lJsonObject->id."/picture&type=large";
      ImageImporter::importByUrlAndUserId($lImgPath, $lUser->getId(), $lOnlineIdentity);
    }

    // import contacts
    $this->importContacts($lOnlineIdentity->getId());

    // save new token
    AuthTokenTable::saveToken($lUser->getId(), $lOnlineIdentity->getId(), $lParamsArray['access_token'], null, true);  // signup,add new

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
  public function addIdentifier($pUser, $pCode) {
    $lAccessToken = $this->getAccessToken($pCode);

    // get params
    $lParamsArray = array();
    // extract params
    parse_str($lAccessToken, $lParamsArray);

    $lJsonObject = json_decode(UrlUtils::sendGetRequest("https://graph.facebook.com/me?access_token=".$lParamsArray['access_token']));

    // facebook identifier
    $lIdentifier = "http://www.facebook.com/profile.php?id=".$lJsonObject->id;

    // ask for online identity
    $lOnlineIdentity = OnlineIdentityTable::retrieveByAuthIdentifier($lIdentifier);

    // check if user already exists
    if ($lOnlineIdentity) {
      if ($lOnlineIdentity->getUserId() && ($pUser->getId() == $lOnlineIdentity->getUserId())) {
        throw new sfException("online identity already added", 1);
      } elseif ($lOnlineIdentity->getUserId() && ($pUser->getId() != $lOnlineIdentity->getUserId())) {
        throw new sfException("online identity already added by someone else", 2);
      }
    } else {
      // check online identity
      $lOnlineIdentity = OnlineIdentityTable::addOnlineIdentity($lJsonObject->link, $this->aCommunityId);
    }

    // delete connected user-cons
    UserIdentityConTable::deleteAllConnections($lOnlineIdentity->getId());  // signup,add new

    // use api complete informations
    $this->completeOnlineIdentity($lOnlineIdentity, $lJsonObject); // signup,add new

    // @todo <todo> encapsulating this
    $lOnlineIdentity->setUserId($pUser->getId());                  /* signup,add new */
    $lOnlineIdentity->setAuthIdentifier($lIdentifier);
    $lOnlineIdentity->save();

    $lUserIdentityCon = new UserIdentityCon();                     /* signup,add new */
    $lUserIdentityCon->setUserId($pUser->getId());
    $lUserIdentityCon->setOnlineIdentityId($lOnlineIdentity->getId());
    $lUserIdentityCon->setVerified(true);
    $lUserIdentityCon->save();
    // </todo>

    $this->importContacts($lOnlineIdentity->getId());

    AuthTokenTable::saveToken($pUser->getId(), $lOnlineIdentity->getId(), $lParamsArray['access_token'], null, true);  // signup,add new

    return $lOnlineIdentity;
  }

  /**
   * Enter description here...
   *
   */
  public function doAuthentication() {
    $lConsumer = $this->getConsumer();

    header("Location: https://graph.facebook.com/oauth/authorize?client_id=".$lConsumer->key."&scope=email,offline_access,publish_stream,read_stream,user_about_me,user_activities,user_likes,read_friendlists,user_website,user_checkins&redirect_uri=".$this->getCallbackUri());
    exit;
  }

  /**
   * retrieve the access token
   *
   * @author Matthias Pfefferle
   * @param string $pCode
   */
  public function getAccessToken($pCode) {
    $lConsumer = $this->getConsumer();

    $lAccessUrl = "https://graph.facebook.com/oauth/access_token?client_id=".$lConsumer->key."&redirect_uri=".$this->getCallbackUri()."&client_secret=".$lConsumer->secret."&code=".$pCode; //&grant_type=client_credentials
    $lAccessToken = UrlUtils::sendGetRequest($lAccessUrl);

    return $lAccessToken;
  }

  /**
   * complete the user with the api json
   *
   * @author Matthias Pfefferle
   * @param User $pUser
   * @param Object $pObject
   */
  public function completeUser(&$pUser, $pObject) {
    $pUser->setUsername(UserUtils::getUniqueUsername(StringUtils::normalizeUsername($pObject->name)));
    $pUser->setDescription($pObject->bio);

    $pUser->setFirstname($pObject->first_name);
    $pUser->setFirstname($pObject->last_name);
    $pUser->setCulture(substr($pObject->locale, 0, 2));

    // add url as online identity
    if ($pObject->website) {
      $lOnlineIdentity = $pUser->addOnlineIdentity($pObject->website);
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
  public function completeOnlineIdentity(&$pOnlineIdentity, $pObject) {
    $pOnlineIdentity->setName($pObject->name);
    //$pOnlineIdentity->setPhoto($pObject->profile_image_url);
    $pOnlineIdentity->setSocialPublishingEnabled(true);

    $pOnlineIdentity->save();
  }
}
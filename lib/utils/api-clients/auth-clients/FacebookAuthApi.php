<?php
/**
 * Enter description here...
 *
 * @author Matthias Pfefferle
 */
class FacebookAuthApiClient extends AuthApi {

  protected $aCommunity = "facebook";

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

    $lJsonObject = json_decode(UrlUtils::sendGetRequest("https://graph.facebook.com/me?access_token=".$lParamsArray['access_token']."&locale=en_US"));

    // facebook identifier
    $lIdentifier = "http://www.facebook.com/profile.php?id=".$lJsonObject->id;

    // ask for online identity
    $lOnlineIdentity = OnlineIdentityTable::retrieveByAuthIdentifier($lIdentifier);

    // check if user already exists
    if ($lOnlineIdentity) {
      $lUser = $lOnlineIdentity->getUser();
    } else {
      // check online identity
      $lOnlineIdentity = OnlineIdentityTable::addOnlineIdentity($lJsonObject->link, $lJsonObject->id, $this->aCommunityId);
      // generate empty user
      $lUser = new User();
    }

    // if there is no user create one
    if (!$lUser || !$lUser->getId()) {
      $this->completeUser($lUser, $lJsonObject);                     // signup
      // use api complete informations
      $this->completeOnlineIdentity($lOnlineIdentity, $lJsonObject, $lUser, $lIdentifier); // signup,add new
    }

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

    $lJsonObject = json_decode(UrlUtils::sendGetRequest("https://graph.facebook.com/me?access_token=".$lParamsArray['access_token']."&locale=en_US"));

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
      $lOnlineIdentity = OnlineIdentityTable::addOnlineIdentity($lJsonObject->link, $lJsonObject->id, $this->aCommunityId);
    }

    // use api complete informations
    $this->completeOnlineIdentity($lOnlineIdentity, $lJsonObject, $pUser, $lIdentifier); // signup,add new

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
    $pUser->setDescription(@$pObject->bio);
    $pUser->setFirstname($pObject->first_name);
    $pUser->setFirstname($pObject->last_name);
    $pUser->setCulture(substr($pObject->locale, 0, 2));
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
    $pOnlineIdentity->setName($pObject->name);
    $pOnlineIdentity->setGender($pObject->gender);

    // transform facebook format into
    $lBirthday = explode('/', $pObject->birthday);
    $pOnlineIdentity->setBirthdate($lBirthday[2].'-'.$lBirthday[0].'-'.$lBirthday[1]);
    $pObject->relationship_status
    $pOnlineIdentity->setSocialPublishingEnabled(true);

    $pOnlineIdentity->setUserId($pUser->getId());                  /* signup,add new */
    $pOnlineIdentity->setAuthIdentifier($pAuthIdentifier);
    $pOnlineIdentity->save();

    $this->importContacts($pOnlineIdentity->getId());

    $lImgPath = "https://graph.facebook.com/".$pObject->id."/picture&type=large";
    $lPayload = serialize(array('path' => $lImgPath, 'user_id' => $pUser->getId(), 'oi_id' => $pOnlineIdentity->getId()));
    AmazonSQSUtils::pushToQuque('ImageImport', $lPayload);
  }
}
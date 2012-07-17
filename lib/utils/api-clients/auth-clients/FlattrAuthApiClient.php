<?php
/**
 * Enter description here...
 *
 * @author Matthias Pfefferle
 */
class FlattrAuthApiClient extends AuthApi {

  protected $aCommunity = "flattr";

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
    $lAccessToken = json_decode($lAccessToken, true);

    $lJsonObject = json_decode(UrlUtils::sendGetRequest("https://api.flattr.com/rest/v2/user", array("Authorization: Bearer ".$lAccessToken["access_token"])));

    // facebook identifier
    $lIdentifier = $lJsonObject->link;

    // ask for online identity
    $lOnlineIdentity = OnlineIdentityTable::retrieveByAuthIdentifier($lIdentifier);

    // check if user already exists
    if ($lOnlineIdentity) {
      $lUser = $lOnlineIdentity->getUser();
    } else {
      // check online identity
      $lOnlineIdentity = OnlineIdentityTable::addOnlineIdentity($lJsonObject->link, $lJsonObject->username, $this->aCommunityId, $lIdentifier);

      // if there is no online identity die!
      if (!$lOnlineIdentity) {
        throw new sfException("incorrect online identity", 3);
      }

      // generate empty user
      $lUser = new User();
    }

    // if there is no user create one
    if (!$lUser || !$lUser->getId() || !$lOnlineIdentity->getPhoto()) {
      $this->completeUser($lUser, $lJsonObject);                     // signup
      // use api complete informations
      $this->completeOnlineIdentity($lOnlineIdentity, $lJsonObject, $lUser, $lIdentifier);
    }

    // save new token
    AuthTokenTable::saveToken($lUser->getId(), $lOnlineIdentity->getId(), $lAccessToken["access_token"], null, true);  // signup,add new

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
    $lAccessToken = json_decode($lAccessToken, true);

    $lJsonObject = json_decode(UrlUtils::sendGetRequest("https://api.flattr.com/rest/v2/user", array("Authorization: Bearer ".$lAccessToken["access_token"])));

    // facebook identifier
    $lIdentifier = $lJsonObject->link;

    // ask for online identity
    $lOnlineIdentity = OnlineIdentityTable::retrieveByAuthIdentifier($lIdentifier);

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
      // check online identity
      $lOnlineIdentity = OnlineIdentityTable::addOnlineIdentity($lJsonObject->link, $lJsonObject->username, $this->aCommunityId, $lIdentifier);
    }

    // use api complete informations
    $this->completeOnlineIdentity($lOnlineIdentity, $lJsonObject, $pUser, $lIdentifier); // signup,add new

    AuthTokenTable::saveToken($pUser->getId(), $lOnlineIdentity->getId(), $lAccessToken["access_token"], null, true);  // signup,add new

    return $lOnlineIdentity;
  }

  /**
   * Enter description here...
   *
   */
  public function doAuthentication() {
    $lConsumer = $this->getConsumer();

    header("Location: https://flattr.com/oauth/authorize?response_type=code&client_id=".$lConsumer->key."&redirect_uri=".$this->getCallbackUri()."&scope=".urlencode("flattr thing email extendedread"));
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

    $lHeaders = array('Authorization: Basic '.base64_encode($lConsumer->key . ':' . $lConsumer->secret), "Content-Type: application/json");
    $lBody = json_encode(array("code" => $pCode, "grant_type" => "authorization_code", "redirect_uri" => $this->getCallbackUri()));

    $lAccessUrl = "https://flattr.com/oauth/token";
    $lAccessToken = UrlUtils::sendPostRequest($lAccessUrl, $lBody, $lHeaders);

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
    $pUser->setUsername(UserUtils::getUniqueUsername(StringUtils::normalizeUsername($pObject->username)));
    $pUser->setActive(true);
    $pUser->setAgb(true);
    $pUser->setFirstname($pObject->firstname);
    $pUser->setEmail($pObject->email);
    $pUser->setLastname($pObject->lastname);
    $pUser->save();
  }

  /**
   * complete the online-identity with the api json
   *
   * @author Matthias Pfefferle
   * @refactored weyandch
   * @param OnlineIdentity $pOnlineIdentity
   * @param Object $pObject
   */
  public function completeOnlineIdentity(&$pOnlineIdentity, $pObject, $pUser, $pAuthIdentifier) {
    // delegate to ImportClient to avoid duplicate code

    $pOnlineIdentity->setUserId($pUser->getId());
    $pOnlineIdentity->setAuthIdentifier($pAuthIdentifier);
    $pOnlineIdentity->setName($pObject->username);

    $pOnlineIdentity->setSocialPublishingEnabled(true);
    $pOnlineIdentity->setLocationRaw($pObject->city);
    $pOnlineIdentity->setPhoto($pObject->avatar);

    $pOnlineIdentity->save();
  }
}
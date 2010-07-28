<?php
/**
 * Enter description here...
 *
 * @author Matthias Pfefferle
 */
class TwitterAuthApiClient {

  const COMMUNITY = "twitter";

  protected $aCommunityId    = null;

  public function __construct() {
    $lCommunity = CommunityTable::retrieveByCommunity("twitter");
    $this->aCommunityId = $lCommunity->getId();
  }

  /**
   * generates a OAuthConsumer
   *
   * @author Matthias Pfefferle
   * @return OAuthConsumer
   */
  public function getConsumer() {
    $lConsumer = new OAuthConsumer();
    $lConsumer->key = sfConfig::get("app_twitter_oauth_token");
    $lConsumer->secret = sfConfig::get("app_twitter_oauth_secret");

    return $lConsumer;
  }

  /**
   * get matching community-object
   *
   * @author Matthias Pfefferle
   * @return Community
   */
  public function getCommunity() {
    $lCommunities = CommunityTable::getInstance()->findBy("community", self::COMMUNITY);

    return $lCommunities[0];
  }

  /**
   * start the sign in process
   *
   * @author Matthias Pfefferle
   * @param myUser $pSessionUser
   * @param AuthToken $pAuthToken
   */
  public function doSignin($pSessionUser, $pOAuthToken) {
    $lAccessToken = $this->getAccessToken($pOAuthToken);

    // get params
    $lParams = $lAccessToken->params;
    $lParamsArray = arry;
    // extract params
    parse_str($lParams, $lParamsArray);

    // twitter identifier
    $lIdentifier = "http://twitter.com/account/profile?user_id=".$lParamsArray['user_id'];

    // ask for online identity
    $lOnlineIdentity = OnlineIdentityTable::retrieveByAuthIdentifier($lIdentifier);
    // check if user already exists
    if ($lOnlineIdentity) {
      // update auth token
      AuthTokenTable::saveToken($lOnlineIdentity->getUserId(), $lOnlineIdentity->getId(), $lParams['oauth_token'], $lParams['oauth_token_secret'], true);
      // returns the user
      return $lOnlineIdentity->getUser();
    } else {
      // get online identity
      $lOnlineIdentity = OnlineIdentityTable::addOnlineIdentity($lParamsArray['screen_name'], $this->aCommunityId);

      $lUser = new User();
      // set username
      $lUser->setUsername(StringUtils::normalizeUsername($lParamsArray['screen_name']));
      $lUser->save();



      // @todo check
      return $lUser;
    }
  }

  /**
   * ask twitter for an access-key
   *
   * @author Matthias Pfefferle
   * @return OAuthToken
   */
  public function getRequestToken() {
    $lRequestToken = OAuthClient::getRequestToken($this->getConsumer(), "http://api.twitter.com/oauth/request_token", 'GET');
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
    $lRequest = OAuthClient::prepareRequest($this->getConsumer(), $lRequestToken, "GET", "http://api.twitter.com/oauth/authenticate");
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
    $lAccessToken = OAuthClient::getAccessToken($this->getConsumer(), "http://api.twitter.com/oauth/access_token ", $pOAuthToken, "GET");

    return $lAccessToken;
  }
}
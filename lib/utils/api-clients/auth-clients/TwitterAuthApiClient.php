<?php
/**
 * Enter description here...
 *
 * @author Matthias Pfefferle
 */
class TwitterAuthApiClient {

  const COMMUNITY = "twitter";

  /**
   * Enter description here...
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
   * Enter description here...
   *
   * @author Matthias Pfefferle
   * @return OAuthToken
   */
  public function getRequestToken() {
    $lRequestToken = OAuthClient::getRequestToken($this->getConsumer(), "http://api.twitter.com/oauth/request_token", 'GET');

    OauthRequestTokenTable::saveToken($lRequestToken);

    return $lRequestToken;
  }

  /**
   * Enter description here...
   *
   */
  public function doAuthentication() {
    $lRequestToken = self::getRequestToken();

    $lRequest = OAuthClient::prepareRequest($this->getConsumer(), $lRequestToken, "GET", "http://api.twitter.com/oauth/authenticate");

    header("Location: " . $lRequest->to_url());
    exit;
  }

  /**
   * Enter description here...
   *
   * @author Matthias Pfefferle
   * @param string $pTokenKey
   */
  public function getAccessToken($pTokenKey) {
    $lRequestToken = OauthRequestTokenTable::retrieveByTokenKey($pTokenKey);

    $lAccessToken = OAuthClient::getAccessToken($this->getConsumer(), "http://api.twitter.com/oauth/access_token ", $lRequestToken, "POST");

    return $lAccessToken;
  }
}
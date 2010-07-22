<?php
/**
 * an OAuth store for symfony
 *
 * @author Matthias Pfefferle
 */
class OAuthSymfonyStore extends OAuthDataStore {

  /**
   * looks up a consumer using a consumer_key
   *
   * @param string $consumer_key
   * @return OAuthConsumer | null
   */
  public function lookup_consumer($consumer_key) {
    $data = $this->get_consumer_data($consumer_key);

    if (!empty($data)) {
      return new OAuthConsumer($data->getCommunity(), $data->getApiKey());
    }

    return null;
  }

  /**
   * looks up a nonce
   *
   * @param OAuthConsumer $consumer
   * @param OAuthToken $token
   * @param string $nonce
   * @param time $timestamp
   * @return string | null
   */
  public function lookup_nonce($consumer, $token, $nonce, $timestamp) {
    OAuthNoncePeer::deleteExpired();

    if (!OAuthNoncePeer::hasBeenUsed($consumer, $token, $nonce)) {
      $lNonceObj = new OAuthNonce();
      $lNonceObj->setConsumerKey( $consumer->key );
      $lNonceObj->setTokenKey( $token->key );
      $lNonceObj->setNonce($nonce);
      $lNonceObj->save();

      return null;
    }

    return $nonce;
  }

  /**
   * looks up a token using
   *
   * @param OAuthConsumer $consumer
   * @param string $token_type for example 'request' or 'access'
   * @param string $token
   *
   * @return OAuthToken | null
   */
  public function lookup_token($consumer, $token_type, $token) {
    $lOAuthConsumerToken = OAuthConsumerTokenPeer::find($consumer, $token_type, $token);

    if (!empty($lOAuthConsumerToken)) {
      return new OAuthToken($lOAuthConsumerToken->getTokenKey(), $lOAuthConsumerToken->getTokenSecret());
    }

    return null;
  }

  /**
   * get a new access token
   *
   * @param OAuthToken $token
   * @param OAuthConsumer $consumer
   *
   * @return OAuthToken | null
   */
  public function new_access_token($token, $consumer) {
    $lConsumer = $this->get_consumer_data($consumer->key);
    $lOAuthConsumerToken = OAuthConsumerTokenPeer::find($consumer, 'request', $token->key);

    if (!empty($lConsumer) && $lOAuthConsumerToken->isAuthorized()) {
      $accessToken = $this->new_token($consumer->key, 'access', $lOAuthConsumerToken->getUserId());
      $lOAuthConsumerToken->delete();

      return $accessToken;
    }

    return null;
  }

  /**
   * get a new request token
   *
   * @param OAuthConsumer $consumer
   * @return OAuthToken | null
   */
  public function new_request_token($consumer) {
    $lConsumer = $this->get_consumer_data($consumer->key);

    if (!empty($lConsumer)) {
      return $this->new_token($consumer->key, 'request');
    }

    return null;
  }

  /**
   * approve a request token
   *
   * @param OAuthRequest $pOAuthRequest
   * @param int $pUserId
   */
  public function approve_token(OAuthRequest $pOAuthRequest, $pUserId) {
    $lOAuthConsumerToken = OAuthConsumerTokenPeer::find(null, 'request', $pOAuthRequest->get_parameter('oauth_token'));

    $lOAuthConsumerToken->setUserId($pUserId);
    $lOAuthConsumerToken->save();
  }

  /**
   * decline and delete a request token
   *
   * @param OAuthRequest $pOAuthRequest
   */
  public function decline_token(OAuthRequest $pOAuthRequest) {
    $lOAuthConsumerToken = OAuthConsumerTokenPeer::find(null, 'request', $pOAuthRequest->get_parameter('oauth_token'));

    if ($lOAuthConsumerToken) {
      $lOAuthConsumerToken->delete();
    }
  }

  /**
   * get a consumer by the consumer-key
   *
   * @param string $consumer_key
   * @return OAuthConsumerRegistry | null
   */
  private function get_consumer_data($consumer_key) {
    return CommunityPeer::getCommunityById($consumer_key, false);
    //return OAuthConsumerRegistryPeer::retrieveByConsumerKey($consumer_key);
  }

  /**
   * generate a new token
   *
   * @param string $consumer_id
   * @param string $token_type
   * @param int $user_id default is 'null'
   * @return OAuthToken
   */
  private function new_token($consumer_id, $token_type, $user_id = null) {

    $key = sha1($_SERVER['REMOTE_ADDR'] . microtime() . (string)rand());
    $secret = sha1(md5($_SERVER['REMOTE_ADDR']) . microtime() . (string)time());

    $lToken = new OAuthConsumerToken();

    $lToken->setConsumerKey($consumer_id);
    $lToken->setTokenKey($key);
    $lToken->setTokenSecret($secret);
    $lToken->setTokenType($token_type);

    if ($user_id != null) {
      $lToken->setUserId($user_id);
    }

    $lToken->save();

    return new OAuthToken($key, $secret);
  }
}

?>

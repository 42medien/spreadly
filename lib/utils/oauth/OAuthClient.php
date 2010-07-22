<?php
/**
 * A simple OAuth consumer component
 *
 * @author Matthias Pfefferle
 */
class OAuthClient {

  /**
   * Call API with a GET request
   *
   * @param OAuthConsumer $consumer
   * @param string $accessTokenKey
   * @param string $accessTokenSecret
   * @param string $url
   * @param array $getData
   * @param array $header if the site needs for example an accept header
   * @return mixed
   */
  public static function get(OAuthConsumer $consumer, $accessTokenKey, $accessTokenSecret, $url, $getData = array(), $signature = null, $header = null) {
    $accessToken = new OAuthToken($accessTokenKey, $accessTokenSecret);
    $request = self::prepareRequest($consumer, $accessToken, 'GET', $url, $getData, $signature);

    return self::doGet($request->to_url(), $header);
  }

  /**
   * request an access token
   *
   * @param OAuthToken $consumer
   * @param string $accessTokenURL
   * @param string $requestToken
   * @param string $httpMethod
   * @param array $parameters
   * @return OAuthToken
   */
  public static function getAccessToken(OAuthConsumer $consumer, $accessTokenURL, $requestToken, $httpMethod = 'POST', $parameters = array(), $signature = null) {
    $request = self::prepareRequest($consumer, $requestToken, $httpMethod, $accessTokenURL, $parameters, $signature);

    return self::doRequest($request);
  }

  /**
   * request an request token
   *
   * @param OAuthToken $consumer
   * @param string $requestToken
   * @param string $httpMethod
   * @param array $parameters
   * @return OAuthToken
   */
  public static function getRequestToken(OAuthConsumer $consumer, $requestTokenURL, $httpMethod = 'POST', $parameters = array(), $signature = null) {
    $request = self::prepareRequest($consumer, null, $httpMethod, $requestTokenURL, $parameters, $signature);

    return self::doRequest($request);
  }

  /**
   * Call API with a POST request
   *
   * @param OAuthConsumer $consumer
   * @param string $accessTokenKey
   * @param string $accessTokenSecret
   * @param string $url
   * @param array $postData
   * @param array $header if the site needs for example an accept header
   * @return mixed
   */
  public static function post(OAuthConsumer $consumer, $accessTokenKey, $accessTokenSecret, $url, $postData = array(), $signature = null, $header = null) {
    $accessToken = new OAuthToken($accessTokenKey, $accessTokenSecret);
    $request = self::prepareRequest($consumer, $accessToken, 'POST', $url, $postData, $signature);

    return self::doPost($url, $request->to_postdata(), $header);
  }

  /**
   * do a get
   *
   * @param string $url
   * @param array $header http header
   * @return string get-body
   */
  private static function doGet($url, $header = null) {
    return UrlUtils::sendGetRequest($url, $header);
  }

  /**
   * do a post
   *
   * @param string $url
   * @param string $data
   * @param array $header http header
   * @return string post-body
   */
  private static function doPost($url, $data, $header = null) {
    return UrlUtils::sendPostRequest($url, $data, $header);
  }

  /**
   * do a request
   *
   * @param OAuthRequest $request
   * @return OAuthToken|null
   */
  private static function doRequest($request) {
    if ($request->get_normalized_http_method() == 'POST') {
      $data = self::doPost($request->get_normalized_http_url(), $request->to_postdata());
    } else {
      $data = self::doGet($request->to_url());
    }

    parse_str($data);

    if (isset($oauth_token) && isset($oauth_token_secret)) {
      return new ExtendedOAuthToken($oauth_token, $oauth_token_secret, $data);
    }

    return null;
  }

  /**
   * prepare the request and sign the request
   *
   * @param OAuthConsumer $consumer
   * @param string $token
   * @param string $httpMethod
   * @param string $url
   * @param array $parameters
   */
  public static function prepareRequest($consumer, $token, $httpMethod, $url, $parameters, $signature = null) {
    if ($signature == null) {
      $signature = new OAuthSignatureMethod_HMAC_SHA1();
    }

    $request = OAuthRequest::from_consumer_and_token($consumer, $token, $httpMethod, $url, $parameters);
    $request->sign_request($signature, $consumer, $token);

    return $request;
  }
}
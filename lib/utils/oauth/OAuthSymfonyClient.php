<?php
/**
 * a symfony class to group all necessary oauth-function
 *
 * @author Matthias Pfefferle
 */
class OAuthSymfonyClient {

  /**
   * checks if an authentication is needed and than redirects to the
   * corresponding site
   *
   * @param string $pUrl
   * @param ApiClient $pApiClient
   * @return string
   */
  public static function createRedirectionUrl($pUrl, $pApiClient) {
    // get user
    $lUser = sfContext::getInstance()->getUser()->getUser();
    // check if there is already an access token
    $lAccessToken = OAuthServiceTokenPeer::getAccessToken($lUser->getId(), $pApiClient->getId());
    if ($lAccessToken) { // if yes, redirect to the normal url
      $lAuthUrl = $pUrl;
    } else { // else get request-token
      $lServiceRegistry = $pApiClient->getOAuthServiceRegistry();

      $lOAuthConsumer = new OAuthConsumer($lServiceRegistry->getConsumerKey(), $lServiceRegistry->getConsumerSecret(), null);

      try {
        $lRequestToken = OAuthClient::getRequestToken($lOAuthConsumer,
                                                      $lServiceRegistry->getRequestUri(),
                                                      'GET',
                                                      $lServiceRegistry->getScope(),
                                                      self::getSignature($lServiceRegistry->getSignatureMethods())
                                                      );
      } catch (Exception $e) {
        throw new OAuthException('wrong consumer settings');
      }

      OAuthServiceTokenPeer::saveRequestToken($lRequestToken, $lUser->getId(), $lServiceRegistry->getId());
      $lAuthUrl = $lServiceRegistry->getAuthorizeUri() . "?oauth_token=".$lRequestToken->key."&oauth_callback=".urlencode($pUrl);
    }

    return $lAuthUrl;
  }

  /**
   * returns an access token
   *
   * @param ApiClient $pApiClient
   * @return OAuthToken
   */
  public static function getAccess($pApiClient, $pUser = null) {
  	if ($pUser) {
  		$lUser = $pUser;
  	} else {
  		$lUser = sfContext::getInstance()->getUser()->getUser();
  	}
    
    $lAccessToken = OAuthServiceTokenPeer::getAccessToken($lUser->getId(), $pApiClient->getId());
    if ($lAccessToken) {
      $lAccessToken = $lAccessToken->convert();
    } else {
      $lServiceRegistry = $pApiClient->getOAuthServiceRegistry();
      $lRequest = sfContext::getInstance()->getRequest();

      $lOAuthKey = $lRequest->getParameter('oauth_token');

      $lRequestToken = OAuthServiceTokenPeer::getRequestToken($lUser->getId(), $lOAuthKey);

      // check if a request token is available
      if ($lRequestToken) {
        // delete request token
        $lRequestToken->delete();
      } else {
        throw new OAuthException('no valid request token');
      }

      $lOAuthConsumer = new OAuthConsumer($lServiceRegistry->getConsumerKey(), $lServiceRegistry->getConsumerSecret(), null);

      // @todo better http error code handling
      try {
        $lAccessToken = OAuthClient::getAccessToken($lOAuthConsumer,
                                                    $lServiceRegistry->getAccessUri(),
                                                    $lRequestToken->convert(),
                                                    $lServiceRegistry->getHttpMethod(),
                                                    $lServiceRegistry->getScope(),
                                                    self::getSignature($lServiceRegistry->getSignatureMethods())
                                                    );
      } catch (Exception $e) {
        throw new OAuthException('request token seems to be invalid');
      }

      OAuthServiceTokenPeer::saveAccessToken($lAccessToken, $lUser->getId(), $lServiceRegistry->getId());
    }

    return $lAccessToken;
  }

  /**
   * wrapper for the signature objects
   *
   * @param string $pSigMethods available signatures comma-separated
   * @return OAuthSignatureMethod
   */
  public static function getSignature($pSigMethods) {
    $lSigMethods = explode(",", $pSigMethods);

    if (in_array('PLAINTEXT', $lSigMethods)) {
      return new OAuthSignatureMethod_PLAINTEXT;
    } else if (in_array('HMAC-SHA1', $lSigMethods)) {
      return new OAuthSignatureMethod_HMAC_SHA1;
    } else if(in_array('RSA-SHA1', $lSigMethods)) {
      return new OAuthSignatureMethod_RSA_SHA1;
    } else {
      return new OAuthSignatureMethod_HMAC_SHA1;
    }
  }

  /**
   * trim the tokens before signing the request
   *
   * @param OAuthToken $pToken
   * @return OAuthToken
   */
  public static function trimToken(OAuthToken $pToken) {
    $pToken->key = trim(urldecode($pToken->key));
    $pToken->secret = trim(urldecode($pToken->secret));

    return $pToken;
  }
}
?>
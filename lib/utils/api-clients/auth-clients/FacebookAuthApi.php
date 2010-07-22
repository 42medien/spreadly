<?php
/**
 * Enter description here...
 *
 * @author Matthias Pfefferle
 */
class FacebookAuthApiClient {

  const COMMUNITY = "facebook";

  /**
   * Enter description here...
   *
   */
  public function doAuthentication() {
    $lClientId = sfConfig::get("app_facebook_oauth_token");

    header("Location: https://graph.facebook.com/oauth/authorize?client_id=$lClientId&redirect_uri=http://www.example.com/oauth_redirect");
    exit;
  }

  /**
   * Enter description here...
   *
   * @author Matthias Pfefferle
   * @param string $pCode
   */
  public function getAccessToken($pCode) {
    $lClientId = sfConfig::get("app_facebook_oauth_token");
    $lClientSecret = sfConfig::get("app_facebook_oauth_secret");

    $lResponse = UrlUtils::sendGetRequest("https://graph.facebook.com/oauth/access_token?
      client_id=$lClientId&
      redirect_uri=http://www.example.com/oauth_redirect&
      client_secret=...&
      code=$pCode");

    return $lAccessToken;
  }
}
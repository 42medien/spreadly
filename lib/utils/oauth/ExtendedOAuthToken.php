<?php
class ExtendedOAuthToken extends OAuthToken {
  public $params;
  public $verifier;

  /**
   * key = the token
   * secret = the token secret
   */
  function __construct($key, $secret, $params, $verifier =  null) {
    $this->key = $key;
    $this->secret = $secret;
    $this->verifier = $verifier;
    $this->params = $params;
  }
}
?>
<?php
class ExtendedOAuthToken extends OAuthToken {
  public $params;

  /**
   * key = the token
   * secret = the token secret
   */
  function __construct($key, $secret, $params) {
    $this->key = $key;
    $this->secret = $secret;
    $this->params = $params;
  }
}
?>
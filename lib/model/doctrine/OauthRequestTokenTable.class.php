<?php
/**
 * Enter description here...
 *
 */
class OauthRequestTokenTable extends Doctrine_Table {

  const CLIENT = 1;
  const SERVER = 2;

  public static function getInstance() {
    return Doctrine_Core::getTable('OauthRequestToken');
  }

  /**
   * saves the request token
   *
   * @author Matthias Pfefferle
   * @param OAuthToken $lToken
   * @return AuthToken
   */
  public static function saveToken($pToken) {
    $lToken = new OauthRequestToken();
    $lToken->setTokenKey($pToken->key);
    $lToken->setTokenSecret($pToken->secret);
    $lToken->save();

    return $lToken;
  }

  /**
   * Enter description here...
   *
   * @author Matthias Pfefferle
   * @param string $pKey
   * @return OauthRequestToken
   */
  public static function retrieveByTokenKey($pKey) {
    $lTokens = self::getInstance()->findBy("token_key", $pKey);

    return $lTokens[0];
  }
}
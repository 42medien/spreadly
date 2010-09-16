<?php
/**
 * auth-tokens for athenticating against for
 * example twitter or facebook
 *
 * @author Matthias Pfefferle
 * @author Christian Weyand
 */
class AuthTokenTable extends Doctrine_Table {

  const TOKEN_TYPE_BASIC   = 1;
  const TOKEN_TYPE_OAUTH   = 2;

  /**
   * returns a new instance
   *
   * @return AuthTokenTable
   */
  public static function getInstance() {
    return Doctrine_Core::getTable('AuthToken');
  }

  /**
   * retrieves all tokens owned by a user
   *
   * @author weyandch
   * @param int $pUserId
   */
  public static function getAllTokensByUser($pUserId) {
    $lQuery = self::getTokensForUserQuery($pUserId);
    $lResults = $lQuery->execute();
    return $lResults;
  }

  /**
   * creates basic query to retrieve tokens for a given user
   *
   * @author Matthias Pfefferle
   * @param int $pUserId
   * @return Doctrine_Query
   */
  public static function getTokensForUserQuery($pUserId) {
    $lQuery = Doctrine_Query::create()
    ->from('AuthToken at')
    ->where('at.user_id = ?', $pUserId)
    ->andWhere('token_type = ?', self::TOKEN_TYPE_OAUTH);
    return $lQuery;
  }

  /**
   * returns a token for a user and online-identity
   *
   * @author Matthias Pfefferle
   * @param int $pUserId
   * @param int $pOnlineIdentityId
   * @return AuthToken
   */
  public static function getByUserAndOnlineIdentity($pUserId, $pOnlineIdentityId) {
    $lResult = Doctrine_Query::create()
      ->from('AuthToken at')
      ->where('at.user_id = ? AND at.online_identity_id = ?', array($pUserId, $pOnlineIdentityId))
      ->fetchOne();

    return $lResult;
  }

  /**
   * updates an auth-token
   *
   * @author Matthias Pfefferle
   * @param int $pUserId
   * @param int $pOnlineIdentityId
   * @param string $pToken
   * @param string $pTokenSecret
   * @param boolean $pActive
   * @return AuthToken
   */
  public static function saveToken($pUserId, $pOnlineIdentityId, $pToken, $pTokenSecret, $pActive = false) {
    if ($lCheck = self::getByUserAndOnlineIdentity($pUserId, $pOnlineIdentityId)) {
      $lToken = $lCheck;
    } else {
      $lToken = new AuthToken();
    }

    if ($pActive && $pOnlineIdentityId) {
      $lIdentity = OnlineIdentityTable::getInstance()->retrieveByPK($pOnlineIdentityId);
      $lIdentity->setSocialPublishingEnabled($pActive);
      $lIdentity->save();
    }

    $lToken->setTokenKey($pToken);
    $lToken->setOnlineIdentityId($pOnlineIdentityId);
    // get online-identity
    $lOnlineIdentity = OnlineIdentityTable::getInstance()->find($pOnlineIdentityId);
    $lToken->setCommunityId($lOnlineIdentity->getCommunityId());
    $lToken->setTokenType(self::TOKEN_TYPE_OAUTH);
    $lToken->setTokenSecret($pTokenSecret);
    $lToken->setUserId($pUserId);
    $lToken->save();

    return $lToken;
  }
}
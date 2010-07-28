<?php
/**
 * Enter description here...
 *
 * @author Matthias Pfefferle
 * @author Christian Weyand
 */
class AuthTokenTable extends Doctrine_Table {

  const TOKEN_TYPE_ACCESS = 'access';
  const TOKEN_TYPE_REQUEST = 'request';


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
   *
   * retrives tokens with publishing enabled by userid
   * @author weyandch
   * @param int $pUserId
   */
  public static function getAllTokensForPublishingByUser($pUserId) {
    $lQuery = self::getTokensForUserQuery($pUserId);
    $lQuery->addWhere('at.is_publishing_enabled = ?', true);
    $lResults = $lQuery->execute();
    return $lResults;
  }

  /**
   * creates basic query to retrieve tokens for a given user
   * @param int $pUserId
   */
  public static function getTokensForUserQuery($pUserId) {
    $lQuery = Doctrine_Query::create()
    ->from('AuthToken at')
    ->where('at.user_id = ?', $pUserId)
    ->andWhere('token_type = ?', self::TOKEN_TYPE_ACCESS);
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
      ->andWhere('token_type = ?', self::TOKEN_TYPE_ACCESS)
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
    $lToken->setTokenSecret($pTokenSecret);
    $lToken->setUserId($pUserId);
    $lToken->save();

    return $lToken;
  }
}
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
   * Enter description here...
   *
   * @param unknown_type $pUserId
   * @param unknown_type $pOnlineIdentityId
   * @param unknown_type $pToken
   * @param unknown_type $pTokenSecret
   * @param unknown_type $pActive
   */
  public static function saveToken($pUserId, $pOnlineIdentityId, $pToken, $pTokenSecret, $pActive = false) {
    if ($lCheck = self::getToken($pUserId, $pOnlineIdentityId)) {
      $lToken = $lCheck;
    } else {
      $lToken = new AuthToken();
    }

    if ($pActive && $pOnlineIdentityId) {
      $lIdentity = OnlineIdentityPeer::retrieveByPK($pOnlineIdentityId);
      $lIdentity->setSocialPublishingEnabled($pActive);
      $lIdentity->save();
    }

    $lToken->setTokenType(self::ACCESS_TOKEN);
    $lToken->setTokenKey($pToken);
    $lToken->setOnlineIdentityId($pOnlineIdentityId);
    $lToken->setTokenSecret($pTokenSecret);
    $lToken->setUserId($pUserId);
    $lToken->save();

    return $lToken;
  }
}
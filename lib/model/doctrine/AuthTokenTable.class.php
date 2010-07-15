<?php


class AuthTokenTable extends Doctrine_Table
{

  public static function getInstance()
  {
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
    ->where('at.user_id = ?', $pUserId);
    return $lQuery;
  }
}
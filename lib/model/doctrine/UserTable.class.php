<?php


class UserTable extends Doctrine_Table {

  public static function getInstance() {
    return Doctrine_Core::getTable('User');
  }

  /**
   * Enter description here...
   *
   * @param unknown_type $pIdentifier
   * @return unknown
   */
  public static function getByIdentifier($pIdentifier) {
    if (preg_match("#(http://)?(.+)\.yiid\.com/?#i", $pIdentifier, $lMatches)) {
      $pIdentifier = $lMatches[2];
    }

    $lQ = Doctrine_Query::create()
            ->from('User u')
            ->where('u.username = ?', array($pIdentifier));

    return $lQ->fetchOne();
  }

  /**
   * Enter description here...
   *
   * @param unknown_type $pIdentifier
   * @param unknown_type $pPassword
   * @return unknown
   */
  public static function getByIdentifierAndPassword($pIdentifier, $pPassword) {
    $lUser = self::getByIdentifier($pIdentifier);

    if ($lUser->verifyPassword($pPassword)) {
      return $lUser;
    } else {
      throw Exception();
    }
  }


  /**
   * wrapper for publishing tokens
   * @param int $pUserId
   */
  public static function getTokensForPublishingByUserId($pUserId) {
    return AuthTokenTable::getAllTokensForPublishingByUser($pUserId);
  }
}
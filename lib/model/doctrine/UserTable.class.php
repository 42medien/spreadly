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

    return self::retrieveByUsername($pIdentifier);
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
    if ($lUser && $lUser->verifyPassword($pPassword)) {
      return $lUser;
    } else {
      throw new Exception();
    }
  }


  /**
   * retrieve a User by its username
   *
   * @author weyandch
   * @param $pUsername
   */
  public static function retrieveByUsername($pUsername) {
    $lQ = Doctrine_Query::create()
    ->from('User u')
    ->where('u.username = ?', $pUsername);

    return $lQ->fetchOne();
  }

  /**
   * wrapper for publishing tokens
   * @param int $pUserId
   */
  public static function getTokensForPublishingByUserId($pUserId) {
    return AuthTokenTable::getAllTokensForPublishingByUser($pUserId);
  }


  /**
   * returns an array with User Objects which are friends to a given userID
   * @author weyandch
   * @param int $pUserId
   * @return Array(User)
   */
  public static function getFriendsForUser($pUserId) {
    $lFriendIds = UserRelationTable::retrieveUserRelations($pUserId)->getContactUid();

    return UserTable::getInstance()->retrieveByPKs($lFriendIds);

  }



}
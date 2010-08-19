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
   * @author Christian Schätzle
   * @param int $pUserId
   * @param int $pPage
   * @param int $pLimit
   * @return Array(User)
   */
  public static function getHottestFriendsForUser($pUserId, $pPage = 1, $pLimit = 10) {
    $lFriendIds = UserRelationTable::retrieveUserRelations($pUserId)->getContactUid();

    return self::getHottestUsers($lFriendIds, $pPage, $pLimit);
  }

  /**
   * returns an array with User Objects which are friends to a given userID
   * @author Christian Schätzle
   * @param int $pUserId
   * @param int $pPage
   * @param int $pLimit
   * @return Array(User)
   */
  public static function getAlphabeticalFriendsForUser($pUserId, $pPage = 1, $pLimit = 10) {
    $lFriendIds = UserRelationTable::retrieveUserRelations($pUserId)->getContactUid();

    return self::getUsersAlphabetically($lFriendIds, $pPage, $pLimit);
  }
  
  /**
   * returns $pLimit hottest users, ready for pagination
   *
   * @author Christian Schätzle
   *
   * @param array $pFriendIds
   * @param integer $pLimit
   * @param integer $pPage
   * @return Doctrine_Collection
   * 
   * @todo sort by hot
   */
  public static function getHottestUsers($pFriendIds, $pPage = 1, $pLimit = 10) {
    $lQuery = Doctrine_Query::create()
        ->from('User u')
        ->whereIn('u.id', $pFriendIds);
        // now sort by hot
        
    $lQuery->limit($pLimit);
    $lQuery->offset(($pPage - 1) * $pLimit);
      
    return $lQuery->execute();
  }
  
  /**
   * returns $pLimit users sorted by sortname and ready for pagination
   *
   * @author Christian Schätzle
   *
   * @param array $pFriendIds
   * @param integer $pLimit
   * @param integer $pPage
   * @return Doctrine_Collection
   * 
   */
  public static function getUsersAlphabetically($pFriendIds, $pPage = 1, $pLimit = 10) {
  	$lQuery = Doctrine_Query::create()
        ->from('User u')
        ->whereIn('u.id', $pFriendIds)
        ->orderBy('u.sortname');
        
    $lQuery->limit($pLimit);  
    $lQuery->offset(($pPage - 1) * $pLimit);
      
    return $lQuery->execute();
  }

  /**
   * returns a users friends filtered by name and ready for pagination
   *
   * @author Matthias Pfefferle
   * @param int $pUserId
   * @param string $pName
   * @param int $pLimit
   * @return array
   */
  public static function getFriendsByName($pUserId, $pName = null, $pPage = 1, $pLimit = 10) {
    $lFriendIds = UserRelationTable::retrieveUserRelations($pUserId)->getContactUid();

    $lQ = Doctrine_Query::create()
      ->from('User u')
      ->whereIn('u.id', $lFriendIds);
      
    if($pName)
      $lQ->andWhere('u.sortname LIKE ?', "%".$pName."%");

    $lQ->limit($pLimit);
    $lQ->offset(($pPage - 1) * $pLimit);
    
    return $lQ->execute();
  }
}
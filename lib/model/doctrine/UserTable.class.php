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
      throw new Exception("wrong username or password");
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
    return OnlineIdentityTable::getPublishingEnabledByUserId($pUserId);
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
    $lUser = UserTable::getInstance()->find($pUserId);
    $lFriendIds = $lUser->getIdsOfFriends();

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
    $lUser = UserTable::getInstance()->find($pUserId);
    $lFriendIds = $lUser->getIdsOfFriends();

    return self::getUsersAlphabetically($lFriendIds, $pPage, $pLimit);
  }

  /**
   * returns $pLimit hottest users, ready for pagination
   *
   * hottest users only, if active within last 30 days
   *
   * @author Christian Schätzle
   *
   * @param array $pFriendIds
   * @param integer $pLimit
   * @param integer $pPage
   * @return Doctrine_Collection
   */
  public static function getHottestUsers($pFriendIds = array(), $pPage = 1, $pLimit = 10) {
    if(empty($pFriendIds)) {
      return false;
    }

    $lQuery = self::getHottestUsersFitlerQuery($pFriendIds);
    $lQuery->limit($pLimit);
    $lQuery->offset(($pPage - 1) * $pLimit);

    return $lQuery->execute();
  }


  /**
   *
   * count hottest users only, if active within last 30 days
   * @param int $pUserId
   * @author weyandch
   */
  public static function countHottestUsers($pUserId) {
    $lUser = UserTable::getInstance()->find($pUserId);
    $lFriendIds = $lUser->getIdsOfFriends();

    if(empty($lFriendIds)) {
      return 0;
    }

    $lQuery = self::getHottestUsersFitlerQuery($lFriendIds);
    return $lQuery->count();
  }

   /**
   *
   * filter query for  hottest users only, if active within last 30 days
   * @param array $pFriendIds
   * @param int $pPage
   * @param int $pLimit
   * @author weyandch
   */
  private static function getHottestUsersFitlerQuery($pFriendIds = array()) {
    $lTimeLimit = time() - (sfConfig::get('app_stream_days_limit', 30) * 86400);

    $lQuery = Doctrine_Query::create()
      ->from('User u')
      ->andWhereIn('u.id', $pFriendIds)
      // today minus 30 days
      ->andWhere('u.last_activity > ?', $lTimeLimit)
      // now sort by hot
      ->orderBy('u.last_activity DESC');

    return $lQuery;
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
    if(empty($pFriendIds)) {
      return false;
    }

    $lQuery = self::getUsersAlphabeticallyFilterQuery($pFriendIds);
    $lQuery->limit($pLimit);
    $lQuery->offset(($pPage - 1) * $pLimit);

    return $lQuery->execute();
  }

  /**
   * returns count of $pLimit
   *
   * @author weyandch
   * @param int $pUserId
   * @return int
   *
   */
  public static function countUsersAlphabetically($pUserId) {
    $lUser = UserTable::getInstance()->find($pUserId);
    $lFriendIds = $lUser->getIdsOfFriends();
    if(empty($lFriendIds)) {
      return 0;
    }
    $lQuery = self::getUsersAlphabeticallyFilterQuery($lFriendIds);
    return $lQuery->count();
  }

  /**
   * generates doctrine query for retrieval and counting of users in alphabetical order
   *
   * @author weyandch
   * @param array $pFriendIds
   * @param int $pPage
   * @param int $pLimit
   * @return DoctrineQueryObject
   */
  private static function getUsersAlphabeticallyFilterQuery($pFriendIds) {
    $lTimeLimit = time() - (sfConfig::get('app_stream_days_limit', 30) * 86400);

    $lQuery = Doctrine_Query::create()
    ->from('User u')
    ->whereIn('u.id', $pFriendIds)
    ->andWhere('u.last_activity > ?', $lTimeLimit)
    ->orderBy('u.sortname ASC');

    return $lQuery;
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
    $lQ = self::getFriendsFilterQuery($pUserId, $pName);
    $lQ->limit($pLimit);
    $lQ->offset(($pPage - 1) * $pLimit);

    return $lQ->execute();
  }


  /**
   * returns a users friends filtered by name counted
   *
   * @author Christian Schätzle
   * @param int $pUserId
   * @param string $pName
   * @return integer
   */
  public static function countFriendsByName($pUserId, $pName = null) {
    $lQ = self::getFriendsFilterQuery($pUserId, $pName);

    return $lQ->count();
  }

  /**
   * generates basic query object to perform search actions on a users friendlist
   *
   * @author weyandch
   * @param int $pUserId
   * @param string $pName
   */
  private static function getFriendsFilterQuery($pUserId, $pName = null) {
    $lUser = UserTable::getInstance()->find($pUserId);
    $lFriendIds = $lUser->getIdsOfFriends();

    if(empty($lFriendIds)) {
      return false;
    }
    $lNameParts = explode(' ', $pName);
    $lLimitDays = sfConfig::get('app_stream_days_limit_search', 0);

    $lQ = Doctrine_Query::create()
      ->from('User u')
      ->distinct()
      ->whereIn('u.id', $lFriendIds);
    if ($lLimitDays > 0) {
      $lQ->andWhere('u.last_activity > ?', strtotime('-'.$lLimitDays. ' days'));
    }
    foreach ($lNameParts as $lName) {
      $lQ->andWhere('u.sortname LIKE ?', '%'.trim($lName).'%');
    }
    return $lQ;
  }

  /**
   * Deletes unverified User with Cascade after given time in days or from a given date
   * @param $pDays Integer
   */
  public static function deleteUnverified($pDays = 30) {
    $lDate = mktime( 0, 0, 0, date("m"), date("d") - $pDays, date("Y"));
    $lDate = date('Y-m-d H:i:s', $lDate);

    $lQuery = Doctrine_Query::create()
      ->from('User u')
      ->where('u.active = 0')
      ->andWhere('u.created_at < ?', $lDate);

    $lUsers = $lQuery->execute();

    foreach ($lUsers as $lUser) {
      $lUser->delete();
    }
  }

  /**
   * Update this timestamp on any like action triggered by a user
   *
   * @author weyandch
   * @param int $pUserId
   * @param int $pTimestamp
   */
  public static function updateLatestActivityForUser($pUserId, $pTimestamp) {
    $lUser = UserTable::getInstance()->retrieveByPk($pUserId);
    $lUser->setLastActivity($pTimestamp);
    $lUser->save();
  }

  /**
   * returns an array with userid's of your friends, who acted on a given social object
   *
   * @param string $pSocialObjectId
   * @param int $pUserId
   * @return array()
   * @author weyandch
   */
  public static function getFriendIdsBySocialObjectId($pSocialObjectId, $pUserId) {
    $dm = MongoManager::getDM();
    $lSocialObject = $dm->getRepository('Documents\SocialObject')->findOne($pSocialObjectId);

    $lUser = UserTable::getInstance()->find($pUserId);
    $lConnectedUsers = $lUser->getIdsOfFriends();

    $lFriendsActive = array();
    if ($lSocialObject && $lConnectedUsers) {
      $lFriendsActive = array_intersect($lSocialObject->getUids(), $lConnectedUsers);
    }
    return $lFriendsActive;
  }
}
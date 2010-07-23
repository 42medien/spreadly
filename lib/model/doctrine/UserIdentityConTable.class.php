<?php


class UserIdentityConTable extends Doctrine_Table
{

  public static function getInstance()
  {
    return Doctrine_Core::getTable('UserIdentityCon');
  }

  /**
   * retrieves all OI's for a given User
   * @author weyandch
   * @param int $pUserId
   */
  public static function getOnlineIdentitiesForUser($pUserId) {
    $q = Doctrine_Query::create()
          ->select('uic.online_identity_id')
          ->from('UserIdentityCon uic')
          ->where('uic.user_id = ?', $pUserId);

    $lUiCons = $q->execute(array(),  Doctrine_Core::HYDRATE_NONE);
    $lUiConIds = HydrationUtils::flattenArray($lUiCons);
    return OnlineIdentityTable::getInstance()->retrieveByPks($lUiConIds);
  }

  /**
   * check and add new user identity con
   *
   * @param OnlineIdentity $pOnlineIdentity
   * @param User $pUser
   * @param unknown_type $pVerified
   * @param unknown_type $pAuthIdentifier
   * @return unknown
   */
  public static function addUserIdentityCon(OnlineIdentity $pOnlineIdentity, User $pUser, $pVerified = false, $pAuthIdentifier = null) {
    // check if there is a connection
    $lUIConnection = self::getByOnlineIdentityAndUser($pOnlineIdentity, $pUser);

    // if OnlineIdentity was alrady saved
    if (!$lUIConnection) {
      if ($pOnlineIdentity->hasVerifiedConnection()) {
        throw new ModelException('OI_DUPLICATE', ModelException::DUPLICATE);
        // else create a new connection
      } elseif ($pOnlineIdentity->getAuthIdentifier() != null && $pAuthIdentifier == null) {
        throw new ModelException("you can't add this identifier", ModelException::NOT_ALLOWED);
      } else {
        $lUIConnection = new UserIdentityCon();
        $lUIConnection->setOnlineIdentity($pOnlineIdentity);
        $lUIConnection->setUser($pUser);
      }
    } elseif ($pVerified == false) {
      throw new ModelException('OI_DUPLICATE', ModelException::DUPLICATE);
    }

    $lUIConnection->setVerified($pVerified);
    $lUIConnection->save();

    if ($pVerified) {
      self::deleteUnverifiedConnections($pOnlineIdentity->getId());
    }

    return $lUIConnection;
  }

  /**
   * get an UserIdentityConnection between an OnlineIdentity and an User
   *
   * @param OnlineIdentity $pOnlineIdentity;
   * @param User $pUser
   * @return UserIdentityCon
   */
  public static function getByOnlineIdentityAndUser(OnlineIdentity $pOnlineIdentity, User $pUser) {
    $lUserIdentityCon = Doctrine_Query::create()
          ->from('UserIdentityCon uic')
          ->where('uic.user_id = ? AND uic.online_identity_id = ?', array($pUser->getId(), $pOnlineIdentity->getId()))
          ->fetchOne();
    return $lUserIdentityCon;
  }



  /**
   * retrieves all yiid users who added a given OI
   *
   * @param OnlineIdentity $pOnlineIdentity
   */
  public static function getUsersConnectedToOnlineIdentity(OnlineIdentity $pOnlineIdentity) {
    $lQuery = Doctrine_Query::create()
          ->from('User u')
          ->leftJoin('u.UserIdentityCons uic')
          ->where('uic.online_identity_id = ?', $pOnlineIdentity->getId());

    return $lQuery->execute();
  }
}
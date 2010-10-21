<?php
/**
 * Subclass for performing query and update operations on the 'online_identity' table.
 *
 * @author Matthias Pfefferle
 * @package lib.model
 */
class OnlineIdentityTable extends Doctrine_Table {

  const TYPE_IDENTITY      = 1;  // OI
  const TYPE_URL           = 2;

  const TYPE_EMAIL         = 11;
  const TYPE_IM            = 12;

  const TYPE_ACCOUNT       = 21;

  const SOCIAL_PUBLISHING_OFF = 0;
  const SOCIAL_PUBLISHING_ON  = 1;

  /**
   * instanciate OnlineIdentityTable
   *
   * @return OnlineIdentityTable
   */
  public static function getInstance() {
    return Doctrine_Core::getTable('OnlineIdentity');
  }

  public static function retrieveByOnlineIdentity($lOIdentity) {
    return self::retrieveByIdentifier($lOIdentity->getIdentifier(), $lOIdentity->getCommunityId(), $lOIdentity->getIdentityType());
  }

  /**
   * retrieve an OnlineIdentity by identifier and service
   *
   * @author Matthias Pfefferle
   * @param string $pIdentifier
   * @param string $pCommunityId
   * @param int $pType
   * @return OnlineIdentity|null
   */
  public static function retrieveByIdentifier($pIdentifier, $pCommunityId) {
    $lOnlineIdentity = Doctrine_Query::create()->
    from('OnlineIdentity oi')->
    where('oi.community_id = ?', $pCommunityId)
    ->fetchOne();
    return $lOnlineIdentity;
  }


  /**
   * gets an OnlineIdentity for a given User
   *
   * @author weyandch
   * @param string $pAuthIdentifier
   * @return mixed OnlineIdentity|null
   */
  public static function retrieveByUserId($pUserId) {
    $lOnlineIdentity = Doctrine_Query::create()
    ->from('OnlineIdentity oi')
    ->where('oi.user_id = ?', $pUserId)
    ->execute();

    return $lOnlineIdentity;
  }

  /**
   * gets ids of all OI's owned by a given User
   *
   * @author weyandch
   * @param string $pAuthIdentifier
   * @return mixed OnlineIdentity|null
   */
  public static function retrieveIdsByUserId($pUserId) {
    $lOnlineIdentityIds = Doctrine_Query::create()
    ->from('OnlineIdentity oi')
    ->select('oi.id')
    ->where('oi.user_id = ?', $pUserId)
    ->execute(array(), Doctrine_Core::HYDRATE_NONE);

    return HydrationUtils::flattenArray($lOnlineIdentityIds);
  }

  /**
   * gets an OnlineIdentifier by his auth identifier
   *
   * @author Matthias Pfefferle
   * @param string $pAuthIdentifier
   * @return mixed OnlineIdentity|null
   */
  public static function retrieveByAuthIdentifier($pAuthIdentifier) {
    $lOnlineIdentity = Doctrine_Query::create()
    ->from('OnlineIdentity oi')
    ->where('oi.auth_identifier = ?', $pAuthIdentifier)
    ->fetchOne();

    return $lOnlineIdentity;
  }


  /**
   * add a new OnlineIdentity object
   *
   * @author Matthias Pfefferle
   * @param string $pProfileUri
   * @param int $pOriginalId
   * @param string $pCommunity
   * @param int $pType
   */
  public static function addOnlineIdentity($pProfileUri, $pOriginalId, $pCommunityId, $pAuthIdentifier = null) {
    // if the identifier is null return null
    if (!$pCommunityId || !$pOriginalId) {
      return null;
    }

    $lOIdentity = new OnlineIdentity();
    $lOIdentity->setOriginalId($pOriginalId);
    $lOIdentity->setProfileUri($pProfileUri);
    $lOIdentity->setCommunityId($pCommunityId);
    if ($pAuthIdentifier) {
      $lOIdentity->setAuthIdentifier($pAuthIdentifier);
    }
    $lOIdentity->save();

    return $lOIdentity;
  }

  /**
   * normalize the urls to prevent redundancy in the database
   *
   * @param string $pUrl
   * @see: http://openid.net/specs/openid-authentication-2_0.html#normalization_example
   */
  public static function normalizeUrl(&$pUrl) {
    //Zend_OpenId::normalizeUrl($pUrl);

    $pUrl = str_replace('http://www.', 'http://', $pUrl);
    $pUrl = str_replace('https://www.', 'https://', $pUrl);
  }

  /**
   * returns a list of social publishing enabled online-identities
   *
   * @author Matthias Pfefferle
   * @param int $pUserId
   * @return Doctrine_Collection
   */
  public static function getPublishingEnabledByUserId($pUserId) {
    $q = Doctrine_Query::create()
    ->from('OnlineIdentity oi')
    ->leftJoin('oi.Community c')
    ->where('oi.user_id = ?', $pUserId)
    ->andWhere('c.social_publishing_possible = ?', true);

    $lOis = $q->execute();
    return $lOis;
  }

  /**
   * returns an array of oi id's that have publishing enabled
   *
   * @author Christian Weyand
   * @param int $pUserId
   * @return Doctrine_Collection
   */
  public static function getPublishingEnabledByUserIdOnlyIds($pUserId) {

    $q = Doctrine_Query::create()
    ->from('OnlineIdentity oi')
    ->select('oi.id')
    ->where('oi.user_id = ?', $pUserId)
    ->andWhere('oi.social_publishing_enabled = ?', true);

    $lOis = $q->execute(array(), Doctrine_Core::HYDRATE_NONE);
    return HydrationUtils::flattenArray($lOis);
  }



  public static function toggleSocialPublishingStatus($pIdentitiesOwnedByUser = array(), $pCheckedIdentities = array()) {
    // remove possible injected oi's not belonging to the user
    $checkedOnlineIdentities = array_intersect($pIdentitiesOwnedByUser, $pCheckedIdentities);

    if (is_array($pIdentitiesOwnedByUser)) {
      self::removeSocialPublishingItems($pIdentitiesOwnedByUser);
    }

    if (is_array($checkedOnlineIdentities)  && count($checkedOnlineIdentities) > 0) {
      self::activateSocialPublishingItems($checkedOnlineIdentities);
    }
  }

  /**
   *
   * @author Christian Weyand
   * @author Matthias Pfefferle
   * @param $pIds
   * @return unknown_type
   */
  public static function removeSocialPublishingItems($pIds) {
    if (!empty($pIds)) {
      $q = Doctrine_Query::create()
      ->update('OnlineIdentity oi')
      ->set('oi.social_publishing_enabled', self::SOCIAL_PUBLISHING_OFF)
      ->whereIn('oi.id', $pIds);

      $q->execute();
      return true;
    }
    return false;
  }


  /**
   *
   * @author Christian Weyand
   * @author Matthias Pfefferle
   * @param $pOnlineIdentitys
   * @return unknown_type
   */
  public static function activateSocialPublishingItems($pIds) {
    if (!empty($pIds)) {
      $q = Doctrine_Query::create()
      ->update('OnlineIdentity oi')
      ->set('oi.social_publishing_enabled', self::SOCIAL_PUBLISHING_ON)
      ->whereIn('oi.id', $pIds);

      $q->execute();
      return true;
    }
    return false;
  }


  /**
   * get a set of oi's where we want to renew their friends
   * @param int $pLimit
   * @return array(int)
   * @author weyandch
   */
  public static function getOnlineIdentityIdsForFriendRenewal($pLimit) {
    $q = Doctrine_Query::create()
    ->from('OnlineIdentity oi')
    ->select('oi.id')
    ->where('oi.user_id IS NOT NULL')
    ->andWhere('oi.social_publishing_enabled = ?', 1)
    ->leftJoin('oi.Community c')
    ->andWhere('c.social_publishing_possible = ?', 1)
    ->limit($pLimit)
    ->orderBy('oi.last_friend_refresh ASC');

    $lOis = $q->execute(array(),  Doctrine_Core::HYDRATE_NONE);
    return $lOis;
  }

  public static function getInintialImport($pLimit) {
    $q = Doctrine_Query::create()
    ->from('AuthToken at')
    ->select('at.online_identity_id');

    $lOis = $q->execute(array(),  Doctrine_Core::HYDRATE_NONE);
    return $lOis;
  }



  public static function getOisFromActivityOrderedByCommunity($pActivity) {
    $lOiids = $pActivity->getOiids();

    if (!empty($lOiids)) {
      $lQuery = Doctrine_Query::create()
      ->from('OnlineIdentity oi')
      ->whereIn('oi.id', $lOiids)
      ->orderBy('oi.community_id ASC');

      $lOis = $lQuery->execute();
      return $lOis;
    }
    return array();
  }


  public static function getFriendsForUserId($pUserId) {
    $lQueryString = array();
    $lOwnedOis = OnlineIdentityTable::retrieveByUserId($pUserId);

    foreach ($lOwnedOis as $lIdentity) {
      if ($lIdentity->getFriendIds() != '') {
        $lQueryString[] = '(oi.community_id = '.$lIdentity->getCommunityId(). ' AND oi.original_id IN ('.$lIdentity->getFriendIds().'))';
      }
    }

    $q = new Doctrine_RawSql();
    $q->select('{oi.user_id}, {oi.id}')
    ->from('online_identity oi')
    ->addComponent('oi', 'OnlineIdentity oi');
    if (!empty($lQueryString)) {
      $q->where(implode(' OR ', $lQueryString));
    }

    $lOis = $q->execute();

    return $lOis;
  }


  /**
   * returns a list of OI's we need for the query
   * @param int $pUserId
   * @param int $pFriendId
   */
  public static function getRelevantOnlineIdentityIdsForQuery($pUserId, $pFriendId) {
    $pOiArray = array();
    if (is_null($pFriendId)) { // get own items and items of all friends
      $pOiArray = IdentityMemcacheLayer::retrieveContactOiIdsByUserId($pUserId);
      $pOiArray = array_merge($pOiArray, OnlineIdentityTable::retrieveIdsByUserId($pUserId));
    } else {   // get all items from a specific friend
      $pOiArray = IdentityMemcacheLayer::retrieveContactOiIdsByUserId($pFriendId);
    }

    return $pOiArray;
  }


}
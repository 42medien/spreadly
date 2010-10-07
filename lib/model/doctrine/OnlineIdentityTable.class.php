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
  public static function retrieveByIdentifier($pIdentifier, $pCommunityId, $pType = self::TYPE_IDENTITY) {
    $lOnlineIdentity = Doctrine_Query::create()->
    from('OnlineIdentity oi')->
    where('oi.identifier = ? AND oi.identity_type = ? AND oi.community_id = ?', array($pIdentifier, $pType, $pCommunityId))
    ->fetchOne();
    return $lOnlineIdentity;
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
   * @param string $pIdentifier
   * @param string $pCommunity
   * @param int $pType
   */
  public static function addOnlineIdentity($pIdentifier, $pCommunityId = null, $pType = self::TYPE_IDENTITY) {
    // if the identifier is null return null
    if (!$pIdentifier) {
      return null;
    }

    $lOIdentity = null;

    // check if identifier is an url
    if (preg_match("/https?:\/\//i", $pIdentifier) && $pType == self::TYPE_IDENTITY) {
      $lOIdentity = self::extractIdentifierfromUrl($pIdentifier, $pCommunityId);
    }

    // or create a new object
    if ($lOIdentity == null) {
      $lOIdentity = new OnlineIdentity();
      $lOIdentity->setIdentifier($pIdentifier);
      $lOIdentity->setCommunityId($pCommunityId);
      $lOIdentity->setIdentityType($pType);
    }

    // check if oi already exists
    if ($lOi = self::retrieveByOnlineIdentity($lOIdentity)) {
      $lOIdentity = $lOi;
    } else {
      $lOIdentity->save();
    }

    return $lOIdentity;
  }

  /**
   * function to split the url to get the userid and the used service
   *
   * @param string $pUrl
   * @param int $pCommunityId
   * @return OnlineIdentity
   */
  public static function extractIdentifierfromUrl($pUrl, $pCommunityId) {
    self::normalizeUrl($pUrl);

    $lCommunities = array();

    // check if there is a community defined
    if ($pCommunityId) {
      $lCommunities[] = CommunityTable::getInstance()->find($pCommunityId);
    } else {
      $lCommunities = CommunityTable::retrieveByDomain(UrlUtils::getDomain($pUrl));
    }

    foreach($lCommunities as $lC) {
      if ($lC->getOiUrl()) {
        $lRegex = '/'.str_replace(array('%s', 'www\.'), array('(.*)', '.*'), preg_quote($lC->getOiUrl(),'/')).'?/i';
        $lMatch = array();

        if (preg_match($lRegex, $pUrl, $lMatch)) {
          $lIdentifier = $lMatch[1];
          // check for trailing '/' and remove
          if (substr($lIdentifier, -1, 1) == "/") {
            $lIdentifier = substr($lIdentifier,0,-1);
          }
          sfContext::getInstance()->getLogger()->debug(print_r($lMatch, true));

          $lOnlineIdentity = new OnlineIdentity();
          $lOnlineIdentity->setIdentifier($lIdentifier);
          $lOnlineIdentity->setCommunityId($lC->getId());

          if ($lC->getCommunity() == "website") {
            $lOnlineIdentity->setIdentityType(self::TYPE_URL);
          } else {
            $lOnlineIdentity->setIdentityType(self::TYPE_IDENTITY);
          }

          return $lOnlineIdentity;
        }
      }
    }

    return null;
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
}
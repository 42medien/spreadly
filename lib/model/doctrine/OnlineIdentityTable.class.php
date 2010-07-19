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

  /**
   * instanciate OnlineIdentityTable
   *
   * @return OnlineIdentityTable
   */
  public static function getInstance() {
    return Doctrine_Core::getTable('OnlineIdentity');
  }

  /**
   * retrieve an OnlineIdentity by identifier and service
   *
   * @author Matthias Pfefferle
   * @param string $pIdentifier
   * @param string $pCommunity
   * @param int $pType
   * @return OnlineIdentity|null
   */
  public static function retrieveByIdentifier($pIdentifier, $pCommunity, $pType = self::TYPE_IDENTITY) {
    $lOnlineIdentity = Doctrine_Query::create()->
      from('OnlineIdentity oi')->
      leftJoin('oi.Community c')->
      where('oi.identifier = ? AND oi.identity_type = ? AND c.community = ?', array($pIdentifier, $pType, $pCommunity))->
      fetchOne();

    return $lOnlineIdentity;
  }

  /**
   * Enter description here...
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

    if (preg_match("/https?:\/\//i", $pIdentifier) && $pType == self::TYPE_IDENTITY) {
      $lOIdentity = self::fromUrl($pIdentity, $pCommunityId);
    }

    if ($lOIdentity == null) {
      $lOIdentity = new OnlineIdentity();
      $lOIdentity->setIdentifier($pIdentifier);
      $lOIdentity->setCommunityId($pCommunityId);
      $lOIdentity->setIdentityType($pType);
    }

    $lOIdentity->save();
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

    if ($pCommunityId) {
      $lCommunities[] = CommunityTable::getInstance()->find($pCommunityId);
    } else {
      $lCommunities = CommunityTable::retrieveByDomain(UrlUtils::getDomain($pUrl));
    }

    foreach($lCommunities as $lC)  {
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
          $lOnlineIdentity->setCommunityId($lC->getCommunity());

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
}
<?php
/**
 * User
 *
 * This class has been auto-generated by the Doctrine ORM Framework
 *
 * @package    yiid
 * @subpackage model
 * @author     Matthias Pfefferle
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class User extends BaseUser {
  /**
   * (non-PHPdoc)
   * @see lib/vendor/symfony/lib/plugins/sfDoctrinePlugin/lib/record/sfDoctrineRecord::__toString()
   */
  public function __toString() {
    return $this->getFullName();
  }

  public function getUniqueId() {
    return "tag:spreadly.com,".date("Y", strtotime($this->getCreatedAt())).":/person/".$this->getId();
  }

  /**
   * function to get the full name (first + last-name)
   *
   * @author Matthias Pfefferle
   * @return string fullname or username
   */
  public function getFullName() {
    if ($this->getFirstname() && $this->getLastname()) {
      return $this->getFirstname() . " " . $this->getLastname();
    } else {
      return $this->getUsername();
    }
  }

  /**
   * calculate age of the user, (rundet jahre, nicht tagesgenau!)
   * @return unknown_type
   */
  public function getAge() {
    if ($this->getBirthdate() && $this->getBirthdate() != '0000-00-00') {
      return date('Y-m-D', time()) - $this->getBirthdate();
    }
    return 0;
  }

  /**
   * function to verify a password
   *
   * @param string $pPassword
   * @return boolean
   */
  public function verifyPassword( $pPassword  ) {
    $lHash = PasswordUtils::salt_password( md5($pPassword), $this->getSalt() );
    if ( $lHash === $this->getPasswordhash() ) {
      return true;
    } else {
      return false;
    }
  }

  public function getFacebook() {
		return $this->getOnlineIdentityProfileUri("facebook");
  }

  public function getTwitter() {
		return $this->getOnlineIdentityProfileUri("twitter");
  }

  public function getLinkedin() {
		return $this->getOnlineIdentityProfileUri("linkedin");
  }
	
  public function getXing() {
		return $this->getOnlineIdentityProfileUri("xing");
  }
	
  public function getTumblr() {
		return $this->getOnlineIdentityProfileUri("tumblr");
  }
	
  public function getFlattr() {
		return $this->getOnlineIdentityProfileUri("flattr");
  }
  
  public function getProfileUrl() {
    $lQuery = Doctrine_Query::create()
      ->from('OnlineIdentity oi')
      ->where('oi.user_id = ?', $this->getId())
      ->andWhere('oi.profile_uri IS NOT NULL')
      ->andWhere('oi.profile_uri != ""');;

    if ($lOi = $lQuery->fetchOne()) {
      return $lOi->getProfileUri();
    }
    
    return null;
    
    // @todo add fallback (find an online identity with profile url)
  }
	
	public function getOnlineIdentityProfileUri($community) {
    if ($OnlineIdentity = OnlineIdentityTable::getInstance()->retrieveByUserIdAndCommunity($this->getId(), $community)) {
      if ($pu = $OnlineIdentity->getProfileUri()) {
        return $pu;
      } else {
        return $OnlineIdentity->getName();
      }
    } else {
      return "none";
    }
	}
	
  /**
   * constructs the sortname of the current user-object
   *
   * @author Matthias Pfefferle
   * @return string
   */
  public function generateSortname() {
    $lSortname = $this->getLastname().$this->getFirstname().$this->getUsername();
    $lSortname = trim($lSortname);

    if (preg_match('/^[^a-zA-Z]/',$lSortname)) {
      $lSortname = '#'.$lSortname;
    }
    return $lSortname;
  }

  /**
   * retrieve an array with all OI Ids of this user
   * @return array(int)
   */
  public function getOnlineIdentitesAsArray() {
    $lIdentityArray = array();
    $lIdentities = $this->getOnlineIdentities();
    foreach ($lIdentities as $lIdentity) {
      $lIdentityArray[] = $lIdentity->getId();
    }
    return $lIdentityArray;
  }

  /**
   * retrieve OI's which are assigned to the user
   * @return array(OnlineIdentity)
   * @author weyandch
   */
  public function getOnlineIdentities() {
    return OnlineIdentityTable::getPublishingEnabledByUserId($this->getId());
  }

  public function getTokensForPublishing() {
    return UserTable::getTokensForPublishingByUserId($this->getId());
  }

  /**
   *
   * retrieves main Avatar for User
   * @author weyandch
   * @return string
   */
  public function getAvatar() {
    // get chosen avatar
    $lQuery = Doctrine_Query::create()
      ->from('OnlineIdentity oi')
      ->where('oi.user_id = ?', $this->getId())
      ->andWhere('oi.use_as_avatar = ?', true);

    if ($lOi = $lQuery->fetchOne()) {
      return $lOi->getPhoto();
    }

    // use latest as fallback
    $lQuery = Doctrine_Query::create()
      ->from('OnlineIdentity oi')
      ->where('oi.user_id = ?', $this->getId())
      ->andWhere('oi.photo IS NOT NULL')
      ->orderBy('oi.updated_at DESC');

    if ($lOi = $lQuery->fetchOne()) {
      return $lOi->getPhoto();
    }

    // use gravatar if still no image
    $hash = md5($this->getUsername()."@spreadly.com");
    return "http://www.gravatar.com/avatar/$hash?d=wavatar";
  }

  /**
   * checks if the user has online-identities
   *
   * @author Matthias Pfefferle
   * @return boolean
   */
  public function hasVerifiedOnlineIdentities() {
    $lCount = Doctrine_Query::create()
      ->from('OnlineIdentity oi')
      ->where('oi.user_id = ?', $this->getId())
      ->count();

    if ($lCount > 0) {
      return true;
    } else {
      return false;
    }
  }

  public function getFriends() {
    $lIds = $this->getIdsOfFriends();

    $q = Doctrine_Query::create()
      ->from('User u')
      ->where('u.id IN ?', $lIds);

    return $q->execute();
  }

  public function getIdsOfFriends() {
    return OnlineIdentityTable::getUserIdsOfFriendsByUserId($this->getId());
  }

  public function getLikeCount() {
    $dm = MongoManager::getDM();
    return $dm->getRepository("Documents\YiidActivity")->findBy(array("u_id" => intval($this->getId())))->count();
  }

  public function getFriendCount() {
    $lCount = 0;
    foreach ($this->getOnlineIdentities() as $oi) {
      $lCount += $oi->getFriendCount();
    }
    return $lCount;
  }

  public function getInfluencerRank() {
    $fc = $this->getFriendCount();
    $rank = "Dominator";
    if($fc < 130) {
      $rank = "Rookie";
    } elseif($fc < 260) {
      $rank = "Establishment";
    } elseif($fc < 520) {
      $rank = "Influencer";
    }
    return  __($rank);
  }

  public function getLastShare() {
    if ($this->getLastActivity()) {
      return (date("d.m.Y", $this->getLastActivity()));
    } else {
      return "none";
    }
  }

  public function getFirstShare() {
    if ($this->getLastActivity()) {
      return (date("d.m.Y", strtotime($this->getCreatedAt())));
    } else {
      return "none";
    }
  }

  public function getShareCount() {
    $dm = MongoManager::getStatsDM();
    $res = $dm->getRepository("Documents\AnalyticsActivity")->createQueryBuilder()
      ->group(array('sh' => true), array('count' => 0))
      ->reduce('function (obj, prev) { prev.count += obj.sh; }')
      ->field("u_id")->equals(intval($this->getId()))
      ->getQuery()
      ->execute();

    if (count($res["retval"]) > 0) {
      return $res["retval"][0]['count'];
    }

    return 0;
  }
}

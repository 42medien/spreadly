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
    if ($this->getBirthdate()) {
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

  /**
   * runs before User->save()
   *
   * @author Matthias Pfefferle
   * @param Doctrine_Event $pEvent
   */
  public function preSave($pEvent) {
    $this->setSortname($this->generateSortname());
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
    return OnlineIdentityTable::retrieveByUserId($this->getId());
  }




  public function getTokensForPublishing() {
    return UserTable::getTokensForPublishingByUserId($this->getId());
  }


  /**
   *
   * retrieves main Avatar for User
   * @author weyandch
   * @return UserAvatar
   */
  public function getMainAvatar() {
    $lAvatar = UserAvatarTable::getMainAvatarForUserId($this->getId());
    if (!$lAvatar) {
      return 'affe';
    }
    return $lAvatar->getAvatar();
  }

  /**
   * returns the users yiid
   *
   * @param boolean $pShowHttp
   * @return string
   */
  public function getYiid($pShowHttp = false) {
    if ($pShowHttp) {
      $lYiid = str_replace('%user%', strtolower($this->getUsername()), sfConfig::get('app_settings_yiid'))."/";
    } else {
      $lYiid = str_replace('http://%user%', strtolower($this->getUsername()), sfConfig::get('app_settings_yiid'));
    }
    return $lYiid;
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
}
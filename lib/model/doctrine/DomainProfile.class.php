<?php

/**
 * DomainProfile
 *
 * This class has been auto-generated by the Doctrine ORM Framework
 *
 * @package    yiid_stats
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class DomainProfile extends BaseDomainProfile
{
  const ERROR_INVALID_URL = 'Url not available!';
  const ERROR_NO_MICROID = 'No microid found!';
  const ERROR_INVALID_MICROID = 'MicroId not valid!';
  const ERROR_VERIFICATION = 'Could not verify domain!';

  public function generateVerificationToken(sfGuardUser $user) {
    $this->setVerificationToken(MicroId::generate('mailto:'.$user->getEmailAddress(), $this->getDomain()));
  }

  public function getDomain() {
    return $this->getProtocol().'://'.$this->getUrl();
  }

  public function isPending() {
    return $this->getState()===DomainProfileTable::STATE_PENDING;
  }

  public function isVerified() {
    return $this->getState()===DomainProfileTable::STATE_VERIFIED;
  }

  public function preSave($obj) {
    $this->generateVerificationToken($this->getSfGuardUser());
  }

  public function verify() {
    $count = $this->getVerificationCount();
    $this->setVerificationCount($count+1);

    $microids = $this->getMicroIdsFromDomain();
    $verified = DomainProfile::ERROR_VERIFICATION;
    if(is_array($microids)) {
      if(count($microids) > 0) {
        foreach ($microids as $microid) {
          if($microid === $this->getVerificationToken()) {
            $verified = true;
          }
        }
        if($verified===true) {
          $this->setState('verified');
        } else {
          $verified = DomainProfile::ERROR_INVALID_MICROID;
        }
      } else {
        $verified = DomainProfile::ERROR_NO_MICROID;
      }
    } else {
      $verified = DomainProfile::ERROR_INVALID_URL;
    }

    $this->save();
    return $verified;
  }

  private function getMicroidsFromDomain() {
    $url = $this->getDomain();
    $protocol = $this->getProtocol();
    if(UrlUtils::checkUrlWithCurl($url, true)) {
      return MicroID::parseString(UrlUtils::getUrlContent($url));
    } else {
      Log::info("Url is not available. checkUrlAvailability() was false", true);
      return null;
    }
  }
}
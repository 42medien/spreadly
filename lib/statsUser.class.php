<?php

class statsUser extends sfGuardSecurityUser
{
  /**
   * returns the short culture code
   *
   * @return string
   */
  public function getShortedCulture() {
    $culture = $this->getCulture();

    return substr($culture, 0, 2);
  }
  public function getUserId() {
    return $this->getGuardUser()->getId();
  }
  public function getVerifiedDomains() {
    $verifiedDomains = array();
    $verifiedDomainProfiles = DomainProfileTable::retrieveVerifiedForUser($this->getGuardUser());
    if($verifiedDomainProfiles != null && count($verifiedDomainProfiles)>0) {
      $verifiedDomains = $verifiedDomainProfiles->getData();
    }

    foreach ($verifiedDomains as $lDomain) {
      $lDomains[] = $lDomain->getUrl();
    }

    return $lDomains;
  }
  public function getDomainProfiles() {
    return DomainProfileTable::retrieveAllForUser($this->getGuardUser());
  }
}

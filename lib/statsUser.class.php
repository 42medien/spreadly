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
    foreach ($this->getVerifiedDomainObjects() as $lDomain) {
      $lDomains[] = $lDomain->getUrl();
    }

    return $lDomains;
  }

  public function getVerifiedDomainsWidthId() {
		$lDomains = array();
		if(count($this->getVerifiedDomainObjects())>0) {

	    foreach ($this->getVerifiedDomainObjects() as $lDomain) {
	      $lDomains[$lDomain->getId()] = $lDomain->getUrl();
	    }
		}

    return $lDomains;
  }

  public function getVerifiedDomainObjects(){
    $verifiedDomains = array();
    $verifiedDomainProfiles = DomainProfileTable::retrieveVerifiedForUser($this->getGuardUser());
    if($verifiedDomainProfiles != null && count($verifiedDomainProfiles)>0) {
      $verifiedDomains = $verifiedDomainProfiles->getData();
    }

    return $verifiedDomains;
  }

  public function getDomainProfiles() {
    return DomainProfileTable::retrieveAllForUser($this->getGuardUser());
  }
  public function isMine($object) {
    return empty($object) ? false : $object->getSfGuardUserId()==$this->getUserId();
  }
}

<?php

class profileComponents extends sfComponents
{

  /**
   *
   * @author Karina Mies
   *
   * @param sfWebRequest $request
   */
  public function executeProfile_info(sfWebRequest $request) {
  	$this->pUser = $this->getUser()->getUser();
  	$this->pIdentities = OnlineIdentityTable::getPublishingEnabledByUserId($this->pUser->getId());
  }
}
?>
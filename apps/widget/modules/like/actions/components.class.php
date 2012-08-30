<?php
class likeComponents extends sfComponents {

	public function executeShare_section(sfWebRequest $request) {
    $this->pIdentities = OnlineIdentityTable::getPublishingEnabledByUserId($this->getUser()->getUserId());

    $this->domain_profile = DomainProfileTable::getInstance()->retrieveByUrl($request->getParameter("url", null));
  }
}
?>
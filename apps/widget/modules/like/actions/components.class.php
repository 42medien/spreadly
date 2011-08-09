<?php
class likeComponents extends sfComponents {

	public function executeShare_section(sfWebRequest $request) {
    $this->pIdentities = OnlineIdentityTable::getPublishingEnabledByUserId($this->getUser()->getUserId());
  }
}
?>
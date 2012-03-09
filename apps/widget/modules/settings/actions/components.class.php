<?php
class settingsComponents extends sfComponents {

	public function executeEdit_settings(sfWebRequest $request) {
		$lUser = $this->getUser()->getUser();
		$this->pUser = $lUser;
		$this->pOis = $lUser->getOnlineIdentities();

	}
}
?>
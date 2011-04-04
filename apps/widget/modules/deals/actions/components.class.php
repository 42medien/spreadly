<?php
class dealsComponents extends sfComponents {

	public function executeCoupon_used(sfWebRequest $request) {
	  $dm = MongoManager::getDM();
		$this->pActivity = $dm->getRepository("Documents\YiidActivity")->find($this->pActivityId);
  }

	public function executeCoupon_unused(sfWebRequest $request) {
	  $dm = MongoManager::getDM();
		$this->pActivity = $dm->getRepository("Documents\YiidActivity")->find($this->pActivityId);
  }
}
?>
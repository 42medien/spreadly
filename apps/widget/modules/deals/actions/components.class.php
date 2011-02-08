<?php
class dealsComponents extends sfComponents {

	public function executeCoupon_used(sfWebRequest $request) {
		$this->pActivity = YiidActivityTable::retrieveById($this->pActivityId);
		//var_dump($this->pActivity);die();
		//$this->pActivity = $this->pDeal[0];
  }
}
?>
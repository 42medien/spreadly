<?php
class dealsComponents extends sfComponents {

	public function executeCoupon_used(sfWebRequest $request) {
		$this->pDeal = DealTable::getInstance()->findBy('id', $this->pDealId);
		$this->pDeal = $this->pDeal[0];
  }
}
?>
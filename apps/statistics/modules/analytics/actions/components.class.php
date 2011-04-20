<?php

class analyticsComponents extends sfComponents
{

  /**
   * set the needed request-params
   *
   * @author KM
   *
   * @param $context
   * @param $module
   * @param $action
   */
	public function initialize($context, $module, $action){
    $parentRet = parent::initialize($context, $module, $action);
		$request = $context->getRequest();
		$this->pDomainProfileId = $request->getParameter('domainid', null);
    $this->pVerifiedDomains = DomainProfileTable::retrieveVerifiedForUser($this->getUser()->getGuardUser());
    $this->pHostId = $request->getParameter('host_id', $this->pVerifiedDomains[0]->getId());
    $this->pAggregation = $request->getParameter('aggregation', 'daily');
    $this->pDateFrom = $request->getParameter('date-from');
    $this->pDateTo = $request->getParameter('date-to');
    $this->pUrl = $request->getParameter('url', null);
    $this->pDealId = $request->getParameter('dealid', null);
    $this->pIsDeal = $request->getParameter('isdeal', false);
    return $parentRet;
	}

  public function executeActive_deal_table(sfWebRequest $request) {
    $domain_profile = DomainProfileTable::getInstance()->findOneBy("url", $this->host);
    $this->deals = array();

    if ($this->pDateTo) {
      $lQuery = Doctrine_Query::create()
                ->from('Deal d')
                ->where(
                  'd.domain_profile_id = ? AND '.
                  'd.deal_state = "approved" AND ('.
                  '((d.start_date BETWEEN ? AND ?) OR (d.end_date BETWEEN ? AND ?)) OR '.
                  '(d.start_date >= ? AND d.end_date <= ?))',

                  array($this->pDomainProfileId,
                        $this->pDateFrom, $this->pDateTo, $this->pDateFrom, $this->pDateTo,
                        $this->pDateFrom, $this->pDateTo));
      $this->deals = $lQuery->execute();
    } else {
      if ($deal = DealTable::getApprovedAndRunning($domain_profile->getDomain())) {
        $this->deals[] = $deal;
      }
    }

  }

  public function executeDeal_filter(sfWebRequest $request){
		$lDealId = $request->getParameter('dealid');
		$this->pDeal = DealTable::getInstance()->find($lDealId);
  }

  public function executeUrl_filter(sfWebRequest $request){}
}
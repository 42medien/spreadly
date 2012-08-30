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
    return $parentRet;
	}
}
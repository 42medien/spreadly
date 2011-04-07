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
    $this->pDateFrom = $request->getParameter('date-from', date('Y-m-d', strtotime("6 days ago")));
    $this->pDateTo = $request->getParameter('date-to', date('Y-m-d'));
    $this->pUrl = $request->getParameter('url', null);
    $this->pDealId = $request->getParameter('dealid', null);
    $this->pIsDeal = $request->getParameter('isdeal', false);
    return $parentRet;
	}

  public function executeTop_url_overall_table(sfWebRequest $request) {
    $dm = MongoManager::getStatsDM();
    $this->urls = $dm->getRepository("Documents\UrlSummary")->findBy(array("host" => $this->host))->limit(10)->sort(array("l" => "DESC", "c" => "DESC"));
  }

  public function executeActive_deal_table(sfWebRequest $request) {
    $domain_profile = DomainProfileTable::getInstance()->findOneBy("url", $this->host);
    $this->deal = DealTable::getApprovedAndRunning($domain_profile->getDomain());
  }

	public function executeFilter_nav(sfWebRequest $request){
    if(count($this->pVerifiedDomains) > 0 && !$this->pHostId) {
	    $this->pHostId = $this->pVerifiedDomains[0]->getId();
    }
	}

  public function executeUrl_table(sfWebRequest $request) {
    $lDomainProfile = DomainProfileTable::getInstance()->find($this->pHostId);
    $this->pData = MongoUtils::getTopActivitiesData($lDomainProfile->getUrl(), $this->pDateFrom, $this->pDateTo, $this->pAggregation);
  }

  public function executeDeal_filter(sfWebRequest $request){
		$lDealId = $request->getParameter('dealid');
		$this->pDeal = DealTable::getInstance()->find($lDealId);
  }

  public function executeUrl_filter(sfWebRequest $request){}

  public function executeDeal_content(sfWebRequest $request){
		$lDealId = $request->getParameter('dealid');
  }
}
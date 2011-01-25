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
    $this->pVerifiedDomains = DomainProfileTable::retrieveVerifiedForUser($this->getUser()->getGuardUser());
    $this->pHostId = $request->getParameter('host_id', $this->pVerifiedDomains[0]->getId());
    $this->pAggregation = $request->getParameter('aggregation', 'daily');
    $this->pDateFrom = $request->getParameter('date-from', date('Y-m-d', strtotime("6 days ago")));
    $this->pDateTo = $request->getParameter('date-to', date('Y-m-d'));
    $this->pCommunity = $request->getParameter('com', 'all');
    $this->pUrl = $request->getParameter('url', null);
    $this->pDealId = $request->getParameter('dealid', null);

    return $parentRet;
	}

	public function executeFilter_nav(sfWebRequest $request){
    $this->pFrom = $request->getParameter('date-from', date('Y-m-d', strtotime("6 days ago")));
    $this->pTo = $request->getParameter('date-to', date('Y-m-d'));

    $this->pVerifiedDomains = DomainProfileTable::retrieveVerifiedForUser($this->getUser()->getGuardUser());
    if(count($this->pVerifiedDomains) > 0 && !$this->pHostId) {
	    $this->pHostId = $this->pVerifiedDomains[0]->getId();
    }

	}

	public function executeChart_line_activities(sfWebRequest $request){
    //$lDomainProfile = DomainProfileTable::getInstance()->find($this->pHostId);
    //$this->pData = MongoUtils::getActivityData($lDomainProfile->getUrl(), $this->pDateFrom, $this->pDateTo, $this->pAggregation);
	}

	public function executeChart_line_urls(sfWebRequest $request){
    $lDomainProfile = DomainProfileTable::getInstance()->find($this->pHostId);
    $this->pData = MongoUtils::getUrlData($lDomainProfile->getUrl(), $this->pDateFrom, $this->pDateTo, $this->pAggregation, $this->pUrl);
	}

	public function executeChart_line_range_views(sfWebRequest $request){
    $lDomainProfile = DomainProfileTable::getInstance()->find($this->pHostId);
		$this->pData = MongoUtils::getMediaPenetrationData($lDomainProfile->getUrl(), $this->pDateFrom, $this->pDateTo, $this->pAggregation);
	}

  public function executeChart_pie_gender_activities(sfWebRequest $request) {
    $lDomainProfile = DomainProfileTable::getInstance()->find($this->pHostId);
    $this->pData = MongoUtils::getGenderData($lDomainProfile->getUrl(), $this->pDateFrom, $this->pDateTo, $this->pAggregation);
  }

  public function executeChart_pie_relationship(sfWebRequest $request) {
    $lDomainProfile = DomainProfileTable::getInstance()->find($this->pHostId);
    $this->pData = MongoUtils::getRelationshipData($lDomainProfile->getUrl(), $this->pDateFrom, $this->pDateTo, $this->pAggregation);
  }

	public function executeChart_line_demo_age(sfWebRequest $request){
    $lDomainProfile = DomainProfileTable::getInstance()->find($this->pHostId);
    $this->pData = MongoUtils::getAgeData($lDomainProfile->getUrl(), $this->pDateFrom, $this->pDateTo, $this->pAggregation);
	}

  public function executeUrl_table(sfWebRequest $request) {
    $lDomainProfile = DomainProfileTable::getInstance()->find($this->pHostId);
    //var_dump($this->pHostId);die();
    $this->pData = MongoUtils::getTopActivitiesData($lDomainProfile->getUrl(), $this->pDateFrom, $this->pDateTo, $this->pAggregation);
  }
}
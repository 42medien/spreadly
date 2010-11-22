<?php

class visit_historyComponents extends sfComponents
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

    return $parentRet;
	}

  /**
   * component for description
   *
   * @author KM, HS
   *
   * @param sfWebRequest $request
   */
  public function executeChart_column_activities_clickbacks(sfWebRequest $request) {
    $lDomainProfile = DomainProfileTable::getInstance()->find($this->pHostId);
    $this->pData = MongoUtils::getActivityData($lDomainProfile->getUrl(), $this->pDateFrom, $this->pDateTo, $this->pAggregation);
  }

  public function executeChart_area_age_distribution(sfWebRequest $request) {
    $lDomainProfile = DomainProfileTable::getInstance()->find($this->pHostId);
    $this->pData = MongoUtils::getAgeData($lDomainProfile->getUrl(), $this->pDateFrom, $this->pDateTo, $this->pAggregation);
  }

  public function executeChart_pie_gender_activities(sfWebRequest $request) {
    $lDomainProfile = DomainProfileTable::getInstance()->find($this->pHostId);
    $this->pData = MongoUtils::getGenderData($lDomainProfile->getUrl(), $this->pDateFrom, $this->pDateTo, $this->pAggregation);
  }

  public function executeChart_pie_demographic_activities(sfWebRequest $request) {
    $lDomainProfile = DomainProfileTable::getInstance()->find($this->pHostId);
    $this->pData = MongoUtils::getRelationshipData($lDomainProfile->getUrl(), $this->pDateFrom, $this->pDateTo, $this->pAggregation);
  }

  public function executeTable_top_activities(sfWebRequest $request) {
    $lDomainProfile = DomainProfileTable::getInstance()->find($this->pHostId);
    $this->pData = MongoUtils::getTopActivitiesData($lDomainProfile->getUrl(), $this->pDateFrom, $this->pDateTo, $this->pAggregation);
  }

  /**
   * component for description
   *
   * @author KM, HS
   *
   * @param sfWebRequest $request
   */
  public function executeChart_line_multiplication_factors(sfWebRequest $request) {
    $lDomainProfile = DomainProfileTable::getInstance()->find($this->pHostId);
    $this->pData = MongoUtils::getActivityData($lDomainProfile->getUrl(), $this->pDateFrom, $this->pDateTo, $this->pAggregation);
  }

  /**
   * component for description
   *
   * @author KM, HS
   *
   * @param sfWebRequest $request
   */
  public function executeChart_column_mediapenetration_clickbacks(sfWebRequest $request) {
    $lDomainProfile = DomainProfileTable::getInstance()->find($this->pHostId);
    $this->pData = MongoUtils::getMediaPenetrationData($lDomainProfile->getUrl(), $this->pDateFrom, $this->pDateTo, $this->pAggregation);
  }

}
?>
<?php

/**
 * analaytics actions.
 *
 * @package    yiid
 * @subpackage analaytics
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class analyticsActions extends sfActions
{


  /**
   * initialize variables and check authentication
   *
   * (non-PHPdoc)
   * @see cache/frontend/prod/config/sfAction#initialize()
   */
  public function preExecute() {
    $request = $this->getRequest();

    $this->pDomainProfileId = $request->getParameter('domainid', null);

    if($this->pDomainProfileId) {
      $this->pDomainProfile = DomainProfileTable::getInstance()->find($this->pDomainProfileId);
      $this->forward404Unless($this->pDomainProfile && ($this->pDomainProfile->getSfGuardUserId() == $this->getUser()->getUserId()));
    }

    $this->pAggregation = $request->getParameter('aggregation', 'daily');
    $this->pDateFrom = $request->getParameter('date-from', date('Y-m-d', strtotime("6 days ago")));
    $this->pDateTo = $request->getParameter('date-to', date('Y-m-d'));
    $this->pCommunity = $request->getParameter('com', 'all');
    $this->pUrl = $request->getParameter('url', null);
    $this->pDealId = $request->getParameter('dealid', null);
    $this->pType = $request->getParameter('type', 'url_activities');
    //first for first click on a deal
    $this->pIsDeal = $request->getParameter('isdeal', false);

  }

 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    $this->getResponse()->setSlot('js_document_ready', $this->getPartial('analytics/init_analytics.js'));
    $this->pActivityCount = MongoUtils::getYesterdaysActivityCountForDomainProfiles($this->pVerifiedDomains);
    $this->pVerifiedDomains = $this->sortDomainProfilesByCount($this->pVerifiedDomains, $this->pActivityCount);
    $domainUrls = array();
    foreach ($this->pVerifiedDomains as $domain) {
      $domainUrls[] = $domain->getUrl();
    }
    $this->pTopActivitiesData = MongoUtils::getYesterdaysTopActivitiesData($domainUrls);

  	$lQuery = DealTable::getInstance()->createQuery()->where('sf_guard_user_id = ?', $this->getUser()->getUserId())->orderBy("created_at DESC");
  	$this->pDeals = $lQuery->execute();
  }


  public function executeStatistics(sfWebRequest $request)
  {
    $this->getResponse()->setSlot('js_document_ready', $this->getPartial('analytics/init_analytics.js'));
    $this->pUrl = MongoUtils::getTopActivityUrl($this->lDomainProfile->getUrl(), $this->pDateFrom, $this->pDateTo, $this->pAggregation);
    $this->pData = MongoUtils::getDataForRange($this->pType, $this->lDomainProfile->getUrl(), $this->pDateFrom, $this->pDateTo, $this->pAggregation, $this->pUrl);
  }

  public function executeGet_analytics_content(sfWebRequest $request){
  	$this->getResponse()->setContentType('application/json');

  	if($this->pType == 'url_activities') {
  		if(!$this->pUrl) {
  	  	$this->pUrl = MongoUtils::getTopActivityUrl($this->lDomainProfile->getUrl(), $this->pDateFrom, $this->pDateTo, $this->pAggregation, $this->pDealId);
  		}
			$lReturn['nav'] = $this->getPartial('analytics/filter_nav', array('pHostId' => $this->pHostId, 'pDateFrom' => $this->pDateFrom, 'pDateTo' => $this->pDateTo, 'pUrl' => $this->pUrl, 'pDealId' => $this->pDealId, 'pIsDeal' => $this->pIsDeal));
  	}


  	$lData = MongoUtils::getDataForRange($this->pType, $this->lDomainProfile->getUrl(), $this->pDateFrom, $this->pDateTo, $this->pAggregation, $this->pUrl, $this->pDealId);

  	if($this->pIsDeal) {
  		$lReturn['content'] =  $this->getPartial('analytics/domain_activities_content', array('pUrl'=> $this->pUrl ,'pCom' => $this->pCommunity, 'pHostId' => $this->pHostId, 'pFrom' => $this->pDateFrom, 'pTo' => $this->pDateTo, 'pData' => $lData));
  	} else {
  		$lReturn['content'] =  $this->getPartial('analytics/'.$this->pType.'_content', array('pUrl'=> $this->pUrl ,'pCom' => $this->pCommunity, 'pHostId' => $this->pHostId, 'pFrom' => $this->pDateFrom, 'pTo' => $this->pDateTo, 'pData' => $lData));
  	}

		return $this->renderText(json_encode($lReturn));
  }

  public function executeDomain_statistics(sfWebRequest $request) {
    $dm = MongoManager::getStatsDM();
  	$this->host = $dm->getRepository("Documents\HostSummary")->findOneBy(array("host" => $this->pDomainProfile->getUrl()));
  }

  public function executeDomain_detail(sfWebRequest $request){
		$lDomainId = $request->getParameter('domainid');
		$this->pDomain = DomainProfileTable::getInstance()->find($lDomainId);

  	$lQuery = DealTable::getInstance()->createQuery()->where('sf_guard_user_id = ?', $this->getUser()->getUserId())->orderBy("created_at DESC");
  	$this->pDeals = $lQuery->execute();

    $this->pActivityCount = MongoUtils::getYesterdaysActivityCountForDomainProfiles($this->pVerifiedDomains);
    $this->pVerifiedDomains = $this->sortDomainProfilesByCount($this->pVerifiedDomains, $this->pActivityCount);
    $domainUrls = array();
    foreach ($this->pVerifiedDomains as $domain) {
      $domainUrls[] = $domain->getUrl();
    }
    $this->pTopActivitiesData = MongoUtils::getYesterdaysTopActivitiesData($domainUrls);
  }

  public function executeUrl_statistics(sfWebRequest $request){
		$lUrl = $request->getParameter('url');
		$this->pUrl = $lUrl;

		$lDomainId = $request->getParameter('domainid');
		$this->pDomain = DomainProfileTable::getInstance()->find($lDomainId);

    $this->pActivityCount = MongoUtils::getYesterdaysActivityCountForDomainProfiles($this->pVerifiedDomains);
    $this->pVerifiedDomains = $this->sortDomainProfilesByCount($this->pVerifiedDomains, $this->pActivityCount);
    $domainUrls = array();
    foreach ($this->pVerifiedDomains as $domain) {
      $domainUrls[] = $domain->getUrl();
    }
    $this->pTopActivitiesData = MongoUtils::getYesterdaysTopActivitiesData($domainUrls);

  	$lQuery = DealTable::getInstance()->createQuery()->where('sf_guard_user_id = ?', $this->getUser()->getUserId())->orderBy("created_at DESC");
  	$this->pDeals = $lQuery->execute();

		//pUrl
  }

  private function sortDomainProfilesByCount($pDomainProfiles, $pCount) {
    $lUnsorted = array();
    foreach ($pDomainProfiles as $domain) {
      $lUnsorted[$domain->getId()] = $domain;
    }

    $lSorted = array();
    foreach ($pCount as $id => $count) {
      $lSorted[] = $lUnsorted[$id];
    }
    return $lSorted;
  }

}

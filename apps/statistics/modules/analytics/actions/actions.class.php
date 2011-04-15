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

    // check if user is allowed to see the statistics page
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
    $this->pVerifiedDomains = DomainProfileTable::retrieveVerifiedForUser($this->getUser()->getGuardUser());
    $domainUrls = array();
    foreach ($this->pVerifiedDomains as $domain) {
      $domainUrls[] = $domain->getUrl();
    }

  	$hostRepo = MongoManager::getStatsDM()->getRepository('Documents\ActivityStats');
    $this->last30ByHost = $hostRepo->findLast30($domainUrls);
    if($this->last30ByHost) {
      $this->last30ByHost = $this->last30ByHost->toArray();
    }

  	$urlRepo = MongoManager::getStatsDM()->getRepository('Documents\ActivityUrlStats');
    $this->last30ByUrl = $urlRepo->findLast30($domainUrls);
    if($this->last30ByUrl) {
      $this->last30ByUrl = $this->last30ByUrl->toArray();
    }

    $this->getResponse()->setSlot('js_document_ready', $this->getPartial('analytics/init_analytics.js'));


    $lQuery = Doctrine_Query::create()
                        ->select('*')
                        ->from('Deal d')
                        ->where('d.sf_guard_user_id = ? AND (d.start_date = ? OR d.end_date >= ?)', array($this->getUser()->getUserId(), date("c", strtotime("30 days ago")), date("c", strtotime("30 days ago"))));

  	$this->pDeals = $lQuery->execute();

  	#var_dump(count($this->pDeals));exit;
    #var_dump($lQuery->getSqlQuery());exit;

  	$dealIds = array();
    foreach ($this->pDeals as $deal) {
      $dealIds[] = intval($deal->getId());
    }

    $urlRepo = MongoManager::getStatsDM()->getRepository('Documents\DealStats');
    $this->last30ByDeal = $urlRepo->findByDealIds($dealIds);
    if($this->last30ByDeal) {
      $this->last30ByDeal = $this->last30ByDeal->toArray();
    }

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
    $this->getResponse()->setSlot('js_document_ready', $this->getPartial('analytics/init_analytics.js'));
    $dm = MongoManager::getStatsDM();
  	$this->pHost = $dm->getRepository("Documents\HostSummary")->findOneBy(array("host" => $this->pDomainProfile->getUrl()));
  }

  public function executeDomain_detail(sfWebRequest $request){
    $this->getResponse()->setSlot('js_document_ready', $this->getPartial('analytics/init_analytics.js'));
    $lDm = MongoManager::getStatsDM();

    $this->pUrls = $lDm->getRepository("Documents\ActivityUrlStats")->findBy(array("host" => $this->pDomainProfile->getUrl(), "day" => new MongoDate(strtotime(date("Y-m-d", strtotime($request->getParameter("date-to")))))));
    $this->pHostSummary = $lDm->getRepository("Documents\ActivityStats")->findOneBy(array("host" => $this->pDomainProfile->getUrl(), "day" => new MongoDate(strtotime(date("Y-m-d", strtotime($request->getParameter("date-to")))))));
  }

  public function executeGet_domain_detail(sfWebRequest $request) {
    $selector = $request->getParameter("date-selector");
    switch ($selector) {
      case "now":
      case "yesterday":
        $request->setParameter("date-from", date("Y-m-d", strtotime($selector)));
        break;
      case "7":
      case "30":
        $request->setParameter("date-from", date("Y-m-d", strtotime("yesterday")));
        $request->setParameter("date-to", date("Y-m-d", strtotime($selector." days ago")));
        break;
    }

    if ($request->getParameter("date-to")) {
      $this->forward('analytics', 'get_domain_detail_by_range');
    } else {
      $this->forward('analytics', 'get_domain_detail_by_day');
    }
  }

  public function executeGet_domain_detail_by_day(sfWebRequest $request) {
    $this->getResponse()->setContentType('application/json');
    $lDm = MongoManager::getStatsDM();

    $yesterday = new MongoDate(strtotime(date("Y-m-d", strtotime("yesterday"))));

    $lUrls = $lDm->getRepository("Documents\ActivityUrlStats")->findBy(array("host" => $this->pDomainProfile->getUrl(), "day" => $yesterday));

    $lHostSummary = $lDm->getRepository("Documents\ActivityStats")->findOneBy(array("host" => $this->pDomainProfile->getUrl(), "day" => $yesterday));

    $lReturn['content'] = $this->getPartial('analytics/domain_detail_content_by_day', array('pUrls' => $lUrls, 'pHostSummary' => $lHostSummary, 'pDomainProfile' => $this->pDomainProfile));

    return $this->renderText(json_encode($lReturn));
  }

  public function executeGet_domain_detail_by_range(sfWebRequest $request) {
    $this->getResponse()->setContentType('application/json');

    $from = $request->getParameter("date-from", date("Y-m-d", strtotime("yesterday")));
    $to = $request->getParameter("date-to");

    $lDomainProfile = DomainProfileTable::getInstance()->find($request->getParameter('domainid'));
    
    $lDm = MongoManager::getStatsDM();
    
    //$lHost = $lDm->getRepository("Documents\HostSummary")->findOneBy(array("host" => $lDomainProfile->getUrl()));
    $lHost = $lDm->getRepository("Documents\ActivityStats")->findByRange(array($lDomainProfile->getUrl()), $from, $to);
    if($lHost) {
      $lHost = $lHost->toArray();
    }

    $lQuery = DealTable::getInstance()->createQuery()->where('sf_guard_user_id = ?', $this->getUser()->getUserId())->orderBy("created_at DESC");
    $lDeals = $lQuery->execute();
    $lReturn['content'] = $this->getPartial('analytics/domain_detail_content_by_range', array('pHost' => $lHost, 'pDeals'=>$lDeals));
    return $this->renderText(json_encode($lReturn));
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

  public function executeTesty(sfWebRequest $request) {
    $repo = MongoManager::getStatsDM()->getRepository('Documents\ActivityStats');
    $repo->findLast30();

  }

  public function executeSelect_period(sfWebRequest $request) {
		$this->pDomainId = $request->getParameter('domainid');
  }

}

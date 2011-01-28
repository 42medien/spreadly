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
   * @author Christian Weyand
   * @see cache/frontend/prod/config/sfAction#initialize()
   */
  public function preExecute() {
    $request = $this->getRequest();
    $this->pVerifiedDomains = DomainProfileTable::retrieveVerifiedForUser($this->getUser()->getGuardUser());
    $this->pHostId = $request->getParameter('host_id', $this->pVerifiedDomains[0]->getId());
    if(count($this->pVerifiedDomains) > 0) {
      $this->lDomainProfile = DomainProfileTable::getInstance()->find($this->pHostId);
      $this->forward404Unless($this->lDomainProfile && $this->lDomainProfile->getSfGuardUserId()==$this->getUser()->getUserId());
    }
    $this->pAggregation = $request->getParameter('aggregation', 'daily');
    $this->pDateFrom = $request->getParameter('date-from', date('Y-m-d', strtotime("6 days ago")));
    $this->pDateTo = $request->getParameter('date-to', date('Y-m-d'));
    $this->pCommunity = $request->getParameter('com', 'all');
    $this->pUrl = $request->getParameter('url', null);
    $this->pDealId = $request->getParameter('dealid', null);
    $this->pType = $request->getParameter('type', 'url_activities');

  }

 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    $this->getResponse()->setSlot('js_document_ready', $this->getPartial('analytics/init_analytics.js'));
  }


  public function executeStatistics(sfWebRequest $request)
  {
    $this->getResponse()->setSlot('js_document_ready', $this->getPartial('analytics/init_analytics.js'));
    $this->pUrl = MongoUtils::getTopActivityUrl($this->lDomainProfile->getUrl(), $this->pDateFrom, $this->pDateTo, $this->pAggregation);
    $this->pData = MongoUtils::getDataForRange($this->pType, $this->lDomainProfile->getUrl(), $this->pDateFrom, $this->pDateTo, $this->pAggregation, $this->pUrl);
  }

  /*
  public function executeGet_analytics_urls(sfWebRequest $request){
  	$this->getResponse()->setContentType('application/json');

  	 if($this->pType == 'url_activities' && !$this->pUrl) {
  	   $this->pUrl = MongoUtils::getTopActivityUrl($this->lDomainProfile->getUrl(), $this->pDateFrom, $this->pDateTo, $this->pAggregation);
  	}

    $lData = MongoUtils::getDataForRange($this->lDomainProfile->getUrl(), $this->pDateFrom, $this->pDateTo, $this->pAggregation, $this->pUrl);

		$lReturn['nav'] = $this->getPartial('analytics/filter_nav', array('pHostId' => $this->pHostId, 'pFrom' => $this->pDateFrom, 'pTo' => $this->pDateTo, 'pUrl' => $this->pUrl, 'pDealId' => $this->pDealId));
    $lReturn['content'] =  $this->getPartial('analytics/url_activities_content', array('pCom' => $this->pCommunity, 'pHostId' => $this->pHostId, 'pFrom' => $this->pDateFrom, 'pTo' => $this->pDateTo, 'pUrl'=> $this->pUrl, 'pData' => $lData));

		return $this->renderText(json_encode($lReturn));
  }*/

  public function executeGet_analytics_content(sfWebRequest $request){
  	$this->getResponse()->setContentType('application/json');

  	if($this->pType == 'url_activities') {
  		if(!$this->pUrl) {
  	  	$this->pUrl = MongoUtils::getTopActivityUrl($this->lDomainProfile->getUrl(), $this->pDateFrom, $this->pDateTo, $this->pAggregation);
  		}
			$lReturn['nav'] = $this->getPartial('analytics/filter_nav', array('pHostId' => $this->pHostId, 'pFrom' => $this->pDateFrom, 'pTo' => $this->pDateTo, 'pUrl' => $this->pUrl, 'pDealId' => $this->pDealId));
  	}


  	$lData = MongoUtils::getDataForRange($this->pType, $this->lDomainProfile->getUrl(), $this->pDateFrom, $this->pDateTo, $this->pAggregation, $this->pUrl);
    $lReturn['content'] =  $this->getPartial('analytics/'.$this->pType.'_content', array('pUrl'=> $this->pUrl ,'pCom' => $this->pCommunity, 'pHostId' => $this->pHostId, 'pFrom' => $this->pDateFrom, 'pTo' => $this->pDateTo, 'pData' => $lData));

		return $this->renderText(json_encode($lReturn));
  }

/*
  public function executeGet_analytics_activities(sfWebRequest $request){
  	$this->getResponse()->setContentType('application/json');
    $lData = MongoUtils::getActivityData($this->lDomainProfile->getUrl(), $this->pDateFrom, $this->pDateTo, $this->pAggregation);
    $lReturn['content'] =  $this->getPartial('analytics/activities_content', array('pCom' => $this->pCommunity, 'pHostId' => $this->pHostId, 'pFrom' => $this->pDateFrom, 'pTo' => $this->pDateTo, 'pData' => $lData));

		return $this->renderText(json_encode($lReturn));
  }


  public function executeGet_analytics_range(sfWebRequest $request){
  	$this->getResponse()->setContentType('application/json');
		$lData = MongoUtils::getMediaPenetrationData($this->lDomainProfile->getUrl(), $this->pDateFrom, $this->pDateTo, $this->pAggregation);
    $lReturn['content'] =  $this->getPartial('analytics/range_content', array('pCom' => $this->pCommunity, 'pHostId' => $this->pHostId, 'pFrom' => $this->pDateFrom, 'pTo' => $this->pDateTo, 'pData' => $lData));

		return $this->renderText(json_encode($lReturn));
  }

  public function executeGet_analytics_age(sfWebRequest $request){
  	$this->getResponse()->setContentType('application/json');
  	$lData = MongoUtils::getDemograficData($this->lDomainProfile->getUrl(), $this->pDateFrom, $this->pDateTo, $this->pAggregation);
    $lReturn['content'] =  $this->getPartial('analytics/demo_age_content', array('pCom' => $this->pCommunity, 'pHostId' => $this->pHostId, 'pFrom' => $this->pDateFrom, 'pTo' => $this->pDateTo, 'pData' => $lData));

		return $this->renderText(json_encode($lReturn));
  }

  public function executeGet_analytics_gender(sfWebRequest $request){
  	$this->getResponse()->setContentType('application/json');
  	$lData = MongoUtils::getDemograficData($this->lDomainProfile->getUrl(), $this->pDateFrom, $this->pDateTo, $this->pAggregation);
    $lReturn['content'] =  $this->getPartial('analytics/demo_gender_content', array('pCom' => $this->pCommunity, 'pHostId' => $this->pHostId, 'pFrom' => $this->pDateFrom, 'pTo' => $this->pDateTo, 'pData' => $lData));

		return $this->renderText(json_encode($lReturn));
  }

  public function executeGet_analytics_relations(sfWebRequest $request){
  	$this->getResponse()->setContentType('application/json');
  	$lData = MongoUtils::getDemograficData($this->lDomainProfile->getUrl(), $this->pDateFrom, $this->pDateTo, $this->pAggregation);
    $lReturn['content'] =  $this->getPartial('analytics/demo_relations_content', array('pCom' => $this->pCommunity, 'pHostId' => $this->pHostId, 'pFrom' => $this->pDateFrom, 'pTo' => $this->pDateTo, 'pData' => $lData));

		return $this->renderText(json_encode($lReturn));
  }*/

}

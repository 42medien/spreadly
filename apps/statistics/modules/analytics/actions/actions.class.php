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
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    $this->getResponse()->setSlot('js_document_ready', $this->getPartial('analytics/init_analytics.js'));
    $this->pVerifiedDomains = DomainProfileTable::retrieveVerifiedForUser($this->getUser()->getGuardUser());
    if(count($this->pVerifiedDomains) > 0) {
      $this->pHostId = $request->getParameter('host_id', $this->pVerifiedDomains[0]->getId());
      $lDomainProfile = DomainProfileTable::getInstance()->find($this->pHostId);
      $this->forward404Unless($lDomainProfile && $lDomainProfile->getSfGuardUserId()==$this->getUser()->getUserId());
    }
    $this->pAggregation = $request->getParameter('aggregation', 'daily');
    $this->pDateFrom = $request->getParameter('date-from', date('Y-m-d', strtotime("6 days ago")));
    $this->pDateTo = $request->getParameter('date-to', date('Y-m-d'));
  }

  public function executeGet_filtered_content(sfWebRequest $request){
  	$this->getResponse()->setContentType('application/json');
    //$lDomainProfile = DomainProfileTable::getInstance()->find($request->getParameter('host_id'));
    $lHostId = $request->getParameter('host_id');
    $lDateFrom = $request->getParameter('date-from', date('Y-m-d', strtotime("6 days ago")));
    $lDateTo = $request->getParameter('date-to', date('Y-m-d'));

		$lReturn['nav'] = $this->getPartial('analytics/filter_nav', array('pHostId' => $lHostId, 'pFrom' => $lDateFrom, 'pTo' => $lDateTo));
    $lReturn['content'] =  $this->getPartial('analytics/activities_content', array('pCom' => 'all', 'pHostId' => $lHostId, 'pFrom' => $lDateFrom, 'pTo' => $lDateTo));

		return $this->renderText(json_encode($lReturn));
  }

  public function executeGet_analytics_activities(sfWebRequest $request){
  	$this->getResponse()->setContentType('application/json');
    //$lDomainProfile = DomainProfileTable::getInstance()->find($request->getParameter('host_id'));
    $lHostId = $request->getParameter('host_id');
    $lDateFrom = $request->getParameter('date-from', date('Y-m-d', strtotime("6 days ago")));
    $lDateTo = $request->getParameter('date-to', date('Y-m-d'));
    $lCommunity = $request->getParameter('com', 'all');

    $lReturn['content'] =  $this->getPartial('analytics/activities_content', array('pCom' => $lCommunity, 'pHostId' => $lHostId, 'pFrom' => $lDateFrom, 'pTo' => $lDateTo));

		return $this->renderText(json_encode($lReturn));
  }

  public function executeGet_analytics_range(sfWebRequest $request){
  	$this->getResponse()->setContentType('application/json');
    //$lDomainProfile = DomainProfileTable::getInstance()->find($request->getParameter('host_id'));
    $lHostId = $request->getParameter('host_id');
    $lDateFrom = $request->getParameter('date-from', date('Y-m-d', strtotime("6 days ago")));
    $lDateTo = $request->getParameter('date-to', date('Y-m-d'));
    $lCommunity = $request->getParameter('com', 'all');

    $lReturn['content'] =  $this->getPartial('analytics/range_content', array('pCom' => $lCommunity, 'pHostId' => $lHostId, 'pFrom' => $lDateFrom, 'pTo' => $lDateTo));

		return $this->renderText(json_encode($lReturn));
  }

  public function executeGet_analytics_age(sfWebRequest $request){
  	$this->getResponse()->setContentType('application/json');
    //$lDomainProfile = DomainProfileTable::getInstance()->find($request->getParameter('host_id'));
    $lHostId = $request->getParameter('host_id');
    $lDateFrom = $request->getParameter('date-from', date('Y-m-d', strtotime("6 days ago")));
    $lDateTo = $request->getParameter('date-to', date('Y-m-d'));
    $lCommunity = $request->getParameter('com', 'all');

    $lReturn['content'] =  $this->getPartial('analytics/demo_age_content', array('pCom' => $lCommunity, 'pHostId' => $lHostId, 'pFrom' => $lDateFrom, 'pTo' => $lDateTo, 'pChart' => null));

		return $this->renderText(json_encode($lReturn));
  }

  public function executeGet_analytics_gender(sfWebRequest $request){
  	$this->getResponse()->setContentType('application/json');
    //$lDomainProfile = DomainProfileTable::getInstance()->find($request->getParameter('host_id'));
    $lHostId = $request->getParameter('host_id');
    $lDateFrom = $request->getParameter('date-from', date('Y-m-d', strtotime("6 days ago")));
    $lDateTo = $request->getParameter('date-to', date('Y-m-d'));
    $lCommunity = $request->getParameter('com', 'all');

    $lReturn['content'] =  $this->getPartial('analytics/demo_gender_content', array('pCom' => $lCommunity, 'pHostId' => $lHostId, 'pFrom' => $lDateFrom, 'pTo' => $lDateTo, 'pChart' => null));

		return $this->renderText(json_encode($lReturn));
  }

  public function executeGet_analytics_relations(sfWebRequest $request){
  	$this->getResponse()->setContentType('application/json');
    //$lDomainProfile = DomainProfileTable::getInstance()->find($request->getParameter('host_id'));
    $lHostId = $request->getParameter('host_id');
    $lDateFrom = $request->getParameter('date-from', date('Y-m-d', strtotime("6 days ago")));
    $lDateTo = $request->getParameter('date-to', date('Y-m-d'));
    $lCommunity = $request->getParameter('com', 'all');

    $lReturn['content'] =  $this->getPartial('analytics/demo_relations_content', array('pCom' => $lCommunity, 'pHostId' => $lHostId, 'pFrom' => $lDateFrom, 'pTo' => $lDateTo, 'pChart' => null));

		return $this->renderText(json_encode($lReturn));
  }
}

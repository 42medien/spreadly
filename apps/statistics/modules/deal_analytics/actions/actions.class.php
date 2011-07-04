<?php

/**
 * deal_analytics actions.
 *
 * @package    yiid
 * @subpackage deal_analytics
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class deal_analyticsActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    //$this->forward('default', 'module');
  }

  public function executeDeal_statistics(sfWebRequest $request) {
		$lDealId = $request->getParameter('deal_id');
		$this->pDeal = DealTable::getInstance()->find($lDealId);
		$this->pDomainProfile = $this->pDeal->getDomainProfile();
    $dm = MongoManager::getStatsDM();
  	$this->pHost = $dm->getRepository("Documents\HostSummary")->findOneBy(array("host" => $this->pDomainProfile->getUrl()));
  	$lEndDate = strtotime($this->pDeal->getEndDate());
  	$this->pEndDate = ($lEndDate < time())?$this->pDeal->getEndDate():date("Y-m-d", strtotime("today"));

  }

  public function executeDeal_details(sfWebRequest $request) {
		$lDealId = $request->getParameter('deal_id');
		$this->pDeal = DealTable::getInstance()->find($lDealId);
		$this->pDomainProfile = $this->pDeal->getDomainProfile();
    $dm = MongoManager::getStatsDM();
  	$this->pHost = $dm->getRepository("Documents\HostSummary")->findOneBy(array("host" => $this->pDomainProfile->getUrl()));
  	$lEndDate = strtotime($this->pDeal->getEndDate());
  	$this->pEndDate = ($lEndDate < time())?$this->pDeal->getEndDate():date("Y-m-d", strtotime("today"));
  	$this->pLikes = $this->getDealLikes($this->pDeal, $this->pEndDate);
    $this->pUrls = $this->getUrlAnalytics($this->pDeal);
  }

  private function getDealLikes($deal, $endDate) {
    $lDm = MongoManager::getStatsDM();
    $lHostsRange = $lDm->getRepository("Documents\DealStats")->findBy(array("d_id" => intval($deal->getId())));
    $lHostsRange = $lHostsRange->toArray();
    return array_values($this->padLikes($lHostsRange, $deal->getStartDate(), $endDate));
  }

  private function getUrlAnalytics($deal) {
    $lDm = MongoManager::getStatsDM();
    return $lDm->getRepository("Documents\DealUrlSummary")->findBy(array("d_id" => intval($deal->getId())));
  }

  private function padLikes($activityStats, $from, $to) {
    $from = new DateTime($from);
    $from->setTime(0,0);
    $to = new DateTime($to);
    $to->setTime(24,0);

    $lDayPeriod = new DatePeriod($from, new DateInterval('P1D'), $to);

    $res = array();
    foreach ($lDayPeriod as $day) {
      $res[$day->format('Y-m-d')] = 0;
    }
    foreach ($activityStats as $stat) {
      $res[$stat->getDay()->format('Y-m-d')] = $stat->getLikes();
    }
    return $res;
  }
}

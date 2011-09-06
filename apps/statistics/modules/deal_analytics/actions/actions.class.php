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
    $lQuery = DealTable::getInstance()->createQuery()
                        ->where('sf_guard_user_id = ?', array($this->getUser()->getUserId()));

  	$this->pDeals = $lQuery->execute();
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

  public function executeDeal_statistics(sfWebRequest $request) {
    $this->getResponse()->setSlot('js_document_ready', $this->getPartial('deal_analytics/init_deal_analytics.js'));
		$lDealId = $request->getParameter('deal_id');
		$this->pDeal = DealTable::getInstance()->find($lDealId);
		$this->pDomainProfile = $this->pDeal->getDomainProfile();

  	$lDealSummary = MongoManager::getStatsDM()->getRepository("Documents\DealSummary")->findOneBy(array("d_id" => intval($lDealId)));

    if (!$lDealSummary) {
      $this->setTemplate("no_stats", "deal_analytics");
    }

  	$lEndDate = strtotime($this->pDeal->getEndDate());
  	$this->pEndDate = ($lEndDate < time())?$this->pDeal->getEndDate():date("d-m-Y", strtotime("today"));

  }

  public function executeDeal_details(sfWebRequest $request) {
    $this->getResponse()->setSlot('js_document_ready', $this->getPartial('deal_analytics/init_deal_analytics.js'));
		$lDealId = $request->getParameter('deal_id');
		$this->pDeal = DealTable::getInstance()->find($lDealId);

  	$lEndDate = strtotime($this->pDeal->getEndDate());
  	$this->pEndDate = ($lEndDate < time())?$this->pDeal->getEndDate():date("Y-m-d", strtotime("today"));
  	$this->pLikes = $this->getDealLikes($this->pDeal, $this->pEndDate);
    $this->pUrlSummaries = $this->getUrlSummaryAnalytics($this->pDeal);
    $this->pUrls = $this->getUrlAnalytics($this->pDeal);
  }

  private function getDealLikes($deal, $endDate) {
    $lDm = MongoManager::getStatsDM();
    $lHostsRange = $lDm->getRepository("Documents\DealStats")->findBy(array("d_id" => intval($deal->getId())));
    $lHostsRange = $lHostsRange->toArray();
    return array_values($this->padLikes($lHostsRange, $deal->getStartDate(), $endDate));
  }

  private function getUrlSummaryAnalytics($deal) {
    $lDm = MongoManager::getStatsDM();
    return $lDm->getRepository("Documents\DealUrlSummary")->findBy(array("d_id" => intval($deal->getId())));
  }

  private function getUrlAnalytics($deal) {
    $lDm = MongoManager::getStatsDM();
    return $lDm->getRepository("Documents\AnalyticsActivity")->findBy(array("d_id" => intval($deal->getId())));
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

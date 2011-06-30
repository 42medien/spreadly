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
  	$this->pEndDate = ($lEndDate > time())?$this->pDeal->getEndDate():date("Y-m-d", strtotime("today"));

  }

  public function executeDeal_details(sfWebRequest $request) {
		$lDealId = $request->getParameter('deal_id');
		$this->pDeal = DealTable::getInstance()->find($lDealId);
  }
}

<?php

/**
 * visit_history actions.
 *
 * @package    yiid_stats
 * @subpackage visit_history
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class visit_historyActions extends sfActions
{

	public function executeIndex(sfWebRequest $request) {

	}

  public function executeAnalytics(sfWebRequest $request){
    $this->getResponse()->setSlot('js_document_ready', $this->getPartial('visit_history/js_init_visit_history.js'));
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
}

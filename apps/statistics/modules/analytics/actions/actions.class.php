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

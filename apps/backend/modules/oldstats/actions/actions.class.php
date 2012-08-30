<?php

/**
 * visit_history actions.
 *
 * @package    yiid_stats
 * @subpackage visit_history
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class oldstatsActions extends sfActions
{

  public function executeIndex(sfWebRequest $request){
    $this->redirect('@oldstats');
  }
  /**
   * display monthly stats overview
   * @param sfWebRequest $request
   */
  public function executeMonthly(sfWebRequest $request){
    $this->getResponse()->setSlot('js_document_ready', $this->getPartial('oldstats/js_init_visit_history.js'));
    $this->pMonth = $request->getParameter('month', date('Y-m'));
    $this->pHost = $request->getParameter('host', null);

    $this->pSortCat = $request->getParameter('sort', 'host');
    $this->pSortOrder = $request->getParameter('order', 'asc');
    $this->pPage = $request->getParameter('page', 1);

    $lQuery = '&month='.$this->pMonth.'&host='.$this->pHost.'&sort='.$this->pSortCat.'&order='.$this->pSortOrder;
    $this->pQuery = $lQuery;

    $this->lHostCount = VisitTable::countHostsForMonth($this->pMonth, $this->pHost);
    $this->lVisits = VisitTable::getMonthlyStatistics($this->pMonth, $this->pHost,  $this->pPage, $this->pSortCat, $this->pSortOrder);
  }
}

<?php
require_once dirname(__FILE__).'/../lib/domainGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/domainGeneratorHelper.class.php';


/**
 * domain actions.
 *
 * @package    yiid
 * @subpackage domain
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class domainActions extends autoDomainActions
{
  public function executeListExportCsv(sfWebRequest $request) {
    $this->pDomainProfiles = DomainProfileTable::getInstance()->createQuery()
                              ->orderBy('created_at DESC')
                              ->execute();

    $this->pOtherUsers = sfGuardUserTable::getInstance()->createQuery()
                              ->from('SfGuardUser s')
                              ->leftJoin('s.DomainProfiles d')
                              ->where('d.id IS NULL')
                              ->execute();
          
    $this->setLayout('csv');
	  $this->getResponse()->clearHttpHeaders();
    $this->getResponse()->setHttpHeader("Content-Type", 'text/csv');
    $this->getResponse()->setHttpHeader('Content-Disposition', 'attachment; filename=DomainProfiles-'.date("Y-m-d").'.csv;');
  }
  
  public function executeJobs(sfWebRequest $request) {
    $this->jobs = MongoManager::getDm()->getRepository('Documents\Job')->findOrdered();
  }

  public function executeAddPointlessJobs(sfWebRequest $request) {
    $stuff = array("blahaha", "bluehuhu", "gnarf", "hulli", "penner", "power horse");
    foreach ($stuff as $s) {
      $pointlessJob = new Documents\PointlessJob($s);
      $dm = MongoManager::getDm();
      $dm->persist($pointlessJob);
      $dm->flush();
    }
    
    var_dump(Queue\Queue::getInstance()->get());
    return $this->redirect('domain/Jobs');
  }
}

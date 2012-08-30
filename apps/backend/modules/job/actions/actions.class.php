<?php

/**
 * job actions.
 *
 * @package    yiid
 * @subpackage domain
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class jobActions extends sfActions
{
  public function executeIndex(sfWebRequest $request) {
    $this->jobs = MongoManager::getDm()->getRepository('Documents\Job')->findOrdered()->limit(500);
  }

  public function executeAddPointlessJobs(sfWebRequest $request) {
    $stuff = array("blahaha", "bluehuhu", "gnarf", "hulli", "penner", "power horse");
    foreach ($stuff as $s) {
      $pointlessJob = new Documents\PointlessJob($s);
      $dm = MongoManager::getDm();
      $dm->persist($pointlessJob);
      $dm->flush();
    }
    
    return $this->redirect('job/index');
  }

  public function executeRemovePointlessJobs(sfWebRequest $request) {
    $dm = MongoManager::getDm();
    $dm ->createQueryBuilder('Documents\Job')
        ->remove()
        ->field('type')->equals('pointless')
        ->getQuery()
        ->execute();
        
    return $this->redirect('job/index');
  }

  public function executeRemoveJobs(sfWebRequest $request) {
    $dm = MongoManager::getDm();
    $dm ->createQueryBuilder('Documents\Job')
        ->remove()
        ->getQuery()
        ->execute();
        
    return $this->redirect('job/index');
  }
  
  public function executeWork(sfWebRequest $request) {
        
    $queue = Queue\Queue::getInstance();
    
    while($job=$queue->get()) {
      try {
        $job->execute();
        $job->finished();
      } catch (Exception $e) {
        $job->reschedule($e->getMessage());
      }
    }
    
    return $this->redirect('job/index');
  }
}

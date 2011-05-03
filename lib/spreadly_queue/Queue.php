<?php
namespace Spreadly\Queue;

use \MongoDate,
    \MongoManager;

/**
 * Queue for scheduled jobs
 *
 * @author Hannes Schippmann
 */
class Queue {
  private static $instance = null;
  private $dm = null;
  
  private function __construct() {
    $this->dm = MongoManager::getDM();
  }
  
  public static function getInstance() {
    if(self::$instance === null) {
      $instance = new Queue();
    }
    return $instance;
  }
  
  public function put($job) {
    $this->dm->persist($job);
  }
  
  public function get() {
    return $dm->createQueryBuilder('Job')
        // Find the job
        ->findAndModify()
        ->returnNew()
        ->field('scheduled')->equals(true)
        ->sort('priority', 'desc')
        ->sort('scheduled_at', 'desc')

        // Update found job
        ->update()
        ->field('started')->set(new MongoDate())
        ->field('scheduled')->set(false)
        ->getQuery()
        ->execute();
  }
  
}

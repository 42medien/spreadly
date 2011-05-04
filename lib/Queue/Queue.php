<?php

namespace Queue;

use \MongoDate,
    \MongoManager;

/**
 * Queue for scheduled jobs. It functions as an adapter for the underlying infrastructure (mongo, amazon sqs, etc.)
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
    return $this->dm->getRepository('Documents\Job')->nextJob();
  }
}

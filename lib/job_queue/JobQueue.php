<?php
/**
 * Job Queue
 *
 * @author Hannes Schippmann
 */
class JobQueue {
  private static $instance = null;
  private $sqs = null;
  private $queue = null;
  
  private function __construct() {
    $this->sqs = new SQS(sfConfig::get('app_amazons3_access_key'), sfConfig::get('app_amazons3_secret_key'), SQS::ENDPOINT_EU_WEST);
    $this->queue = $this->sqs->createQueue(sfConfig::get('app_job_queue_name'));
  }
  
  public static function getInstance() {
    if(self::$instance == null) {
      $instance = new JobQueue();
    }
    return $instance;
  }
  
  public function put($job) {
    // build message from $job suitable for sending to amazon queue
    //sendMessage to Amazon
  }
  
  public function get() {
    // receiveMessage from Amazon
    // build Job according to type
    // return $job;
  }
  
}

<?php
namespace Documents;

use Documents\Job;

/**
 * PointlessJob
 * @author Hannes Schippmann
 * @Document
 */
class PointlessJob extends Job {
  protected $the_job;
  
  public function __construct($the_job) {
   $this->the_job = $the_job;
  }
    
  public function execute() {
    if(mt_rand(10)==10) {
      throw new Exception("Something baaaad happened, bitch!");
    } else {
      sfContext::getInstance()->getLogger()->notice("{PointlessJob} pointlessly doing this: ". $this->the_job);      
    }
  }
}

<?php
require_once dirname(__file__).'/../../lib/BaseTestCase.php';

use Documents\PointlessJob,
    Documents\Job,
    Queue\Queue,
    \MongoManager;

class QueueTest extends BaseTestCase {

  public static function setUpBeforeClass() {
    date_default_timezone_set('Europe/Berlin');
  }

  public function setUp() {
    $this->queue = Queue::getInstance();
    $this->dm = MongoManager::getDM();
    $this->jobRepo = $this->dm->getRepository('Documents\Job');
    $this->jobRepo->createQueryBuilder()
                  ->remove()
                  ->getQuery()
                  ->execute();
  }
  
  public function testQueuePutJob() {
    $jobs = $this->jobRepo->findAll();
    $this->assertEquals(0, count($jobs));
    $job = new PointlessJob("Tadaaa");
    $this->queue->put($job);
    $jobs = $this->jobRepo->findAll();
    $this->assertEquals(1, count($jobs));
  }
  
  public function testInitialJobValues() {
    $job = new PointlessJob("Tadaaa");
    $this->queue->put($job);
    $this->assertEquals(1, $job->getPriority());
    $this->assertTrue($job->getScheduled());
    $this->assertEquals(1, $job->getScheduleCount());
    $this->assertEquals("Tadaaa", $job->getTheJob());
  }
  
  public function testQueueGetJob() {
    $job = new PointlessJob("Tadaaa");
    $this->queue->put($job);
    $otherJob = $this->queue->get();
    $this->assertEquals($job, $otherJob);
  }
  
  public function testJobsValuesAfterGet() {
    $job1 = new PointlessJob("Job 1");
    $this->queue->put($job1);
    
    $this->assertTrue($job1->getScheduled());
    $this->assertTrue($job1->getStartedAt()==null);

    $job = $this->queue->get();
    
    $this->assertFalse($job->getScheduled());
    $this->assertFalse($job->getStartedAt()==null);
    $this->assertTrue($job->getStartedAt() > $job->getScheduledAt());
  }
  
  public function testOrderOfJobs() {
    $job1 = new PointlessJob("Job 1");
    $this->queue->put($job1);
    $job2 = new PointlessJob("Job 2");
    $this->queue->put($job2);
    $job3 = new PointlessJob("Job 3");
    $this->queue->put($job3);
    
    // Should get the jobs fifo from the queue
    $this->assertEquals($job1, $this->queue->get());
    $this->assertEquals($job2, $this->queue->get());
    $this->assertEquals($job3, $this->queue->get());
    
    // Should be empty after all jobs out
    $this->assertEquals(null, $this->queue->get());    
  }
  
}
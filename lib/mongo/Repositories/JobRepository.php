<?php
namespace Repositories;

use Doctrine\ODM\MongoDB\DocumentRepository,
    \MongoDate;


class JobRepository extends DocumentRepository {
  public function nextJob() {
    $job = $this->createQueryBuilder()
                ->find()
                ->field('scheduled')->equals(true)
                ->sort('priority', 'desc')
                ->sort('scheduled_at', 'asc')
                ->getQuery()
                ->getSingleResult();
    
    if($job) {
      $job->setStartedAt(new MongoDate());
      $job->setScheduled(false);
      $job->save();
    }

    return $job;    
  }

  public function findOrdered() {
    return $this->createQueryBuilder()
                ->find()
                ->sort('scheduled', 'desc')
                ->sort('priority', 'desc')
                ->sort('scheduled_at', 'asc')
                ->getQuery()
                ->execute();
  }
}

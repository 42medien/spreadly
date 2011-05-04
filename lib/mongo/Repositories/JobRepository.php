<?php
namespace Repositories;

use Doctrine\ODM\MongoDB\DocumentRepository,
    \MongoDate;


class JobRepository extends DocumentRepository {
  public function next() {
    return $this->createQueryBuilder()
                // Find the job
                ->findAndUpdate()
                ->returnNew(true)
                ->field('scheduled')->equals(true)
                ->sort('priority', 'desc')
                ->sort('scheduled_at', 'asc')

                // Update found job
                ->update()
                ->field('started_at')->set(new MongoDate())
                ->field('scheduled')->set(false)
                ->getQuery()
                ->execute();
  }

  public function findOrdered() {
    return $this->createQueryBuilder()
                // Find the job
                ->find()
                ->sort('scheduled', 'desc')
                ->sort('priority', 'desc')
                ->sort('scheduled_at', 'asc')
                ->getQuery()
                ->execute();
  }
}

<?php
namespace Repositories;

use Doctrine\ODM\MongoDB\DocumentRepository,
    \MongoDate;


class JobRepository extends DocumentRepository {
  public function next() {
    return $this->createQueryBuilder()
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

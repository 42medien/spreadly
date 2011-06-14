<?php
namespace Repositories;

use Doctrine\ODM\MongoDB\DocumentRepository;

class YiidActivityRepository extends DocumentRepository
{

  /**
   * returns the latest activities of a user (desc order by date)
   *
   * @author Matthias Pfefferle
   * @param int $pUserId
   * @param int $pLimit default = 10
   * @return array
   */
  public function findLatestByUserId($u_id, $limit = 10) {
    $results = $this->createQueryBuilder()
                    ->hydrate(true)
                    ->limit($limit)
                    ->field("u_id")->equals(intval($u_id))
                    ->field("d_id")->exists(false)
                    ->sort("c", "desc")
                    ->getQuery()->execute();

    return $results;
  }

  public function countByRange($from, $to) {
    $results = $this->createQueryBuilder()
                    ->field("c")->gte($from)
                    ->field("c")->lte($to)
                    ->getQuery()->execute();

    return $results->count();
  }
}
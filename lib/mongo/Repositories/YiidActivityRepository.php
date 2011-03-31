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
  public function findLatestByUserId($pUserId, $pLimit = 10) {
    $results = $this->createQueryBuilder()
                    ->hydrate(true)
                    ->limit($pLimit)
                    ->field("u_id")->equals(intval($pUserId))
                    ->field("d_id")->exists(false)
                    ->sort("c", "desc")
                    ->getQuery()->execute();

    return $results;
  }
}
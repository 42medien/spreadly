<?php
namespace Repositories;

use Doctrine\ODM\MongoDB\DocumentRepository,
    \MongoDate;


abstract class StatsRepository extends DocumentRepository
{
  /**
   * This is the base query for most of the stats finders
   *
   * @author Hannes Schippmann
   */
  protected function queryForHostAndRange($host, $fromDay, $toDay) {
    return $this->createQueryBuilder()
                    ->field("host")->equals($host)
                    ->field("day")->range(new MongoDate(strtotime($fromDay)), new MongoDate(strtotime($toDay)))
                    ->sort("day", "desc")
                    ->getQuery();
  }
  
  
}

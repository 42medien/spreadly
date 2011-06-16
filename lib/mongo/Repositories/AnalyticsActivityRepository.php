<?php
namespace Repositories;

use \MongoDate,
    Documents\ActivityStats,
    Documents\ActivityUrlStats,
    Documents\Stats;

class AnalyticsActivityRepository extends StatsRepository
{
  public function groupByUsers($fromDay, $toDay) {
    
    $result = $this->dm->createQueryBuilder('Documents\User')
      ->group(array('u_id'), array('count' => 0))
      ->reduce('function (obj, prev) { prev.count++; }')
      ->field("day")->gte(new MongoDate($fromDay))
      ->field("day")->lte(new MongoDate($toDay))
      ->sort('count', 'desc')
      ->getQuery()
      ->execute();
  }
}
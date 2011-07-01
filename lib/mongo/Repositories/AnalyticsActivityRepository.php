<?php
namespace Repositories;

use \MongoDate,
    Documents\ActivityStats,
    Documents\ActivityUrlStats,
    Documents\Stats;

class AnalyticsActivityRepository extends StatsRepository
{
  public function groupByUsers($fromDay, $toDay) {
    return $this->groupBy(array('u_id' => true), $fromDay, $toDay);
  }

  public function groupByHosts($fromDay, $toDay) {
    return $this->groupBy(array('host' => true), $fromDay, $toDay);
  }
  
  public function groupByUrls($fromDay, $toDay) {
    return $this->groupBy(array('url' => true), $fromDay, $toDay);
  }
  
  private function groupBy($groupBy, $fromDay, $toDay) {
    $res = $this->createQueryBuilder()
      ->group($groupBy, array('count' => 0))
      ->reduce('function (obj, prev) { prev.count++; }')
      ->field("date")->gte(new MongoDate($fromDay))
      ->field("date")->lte(new MongoDate($toDay))
      ->getQuery()
      ->execute();
    $arr = $res['retval'];
    usort($arr, function($a, $b) {
      return $b['count'] - $a['count'];
      }
    );
    return $arr;    
  }
} 
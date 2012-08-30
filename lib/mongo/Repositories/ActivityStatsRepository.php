<?php
namespace Repositories;

use \MongoDate,
    Documents\ActivityStats,
    Documents\ActivityUrlStats,
    Documents\Stats;

class ActivityStatsRepository extends StatsRepository
{
  protected $GROUP_BY = "host";

  public function findByHostAndRange($host, $fromDay, $toDay) {
    return $this->queryForHostAndRange($host, $fromDay, $toDay)->execute();
  }
  
}

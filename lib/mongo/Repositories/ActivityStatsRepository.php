<?php
namespace Repositories;

use \MongoDate;

class ActivityStatsRepository extends StatsRepository
{
  public function findByHostAndRange($host, $fromDay, $toDay) {
    return $this->queryForHostAndRange($host, $fromDay, $toDay)->execute();
  }
}

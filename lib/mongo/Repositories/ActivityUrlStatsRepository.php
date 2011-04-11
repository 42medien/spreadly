<?php
namespace Repositories;
use \MongoDate,
    Documents\ActivityStats,
    Documents\ActivityUrlStats,
    Documents\Stats;
    
class ActivityUrlStatsRepository extends StatsRepository
{
  protected $GROUP_BY = "url";

}
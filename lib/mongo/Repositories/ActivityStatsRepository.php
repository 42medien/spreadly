<?php
namespace Repositories;

use \MongoDate,
    Documents\ActivityStats,
    Documents\Stats;

class ActivityStatsRepository extends StatsRepository
{
  public function findByHostAndRange($host, $fromDay, $toDay) {
    return $this->queryForHostAndRange($host, $fromDay, $toDay)->execute();
  }
  
  public function findLast30() {
    
    return $this->createQueryBuilder()
               #->field('host')->equals($host)
               ->map(
                 'function() { 
                   emit(
                     this.host, '.
                     str_replace('"', '', Stats::toJsonMap("this", true))
                     .');
                  }')               
               ->reduce(
                 "function(key, values) {
                     var sum = ".Stats::toJsonMap().";
                     
                    for(var i in values) {".
                      Stats::toBaseSumString()
                      .
                      Stats::toDemographicsSumString()
                      .
                      Stats::toServicesSumString()
                    ."}
                    return sum;
                  }")
                  ->getQuery(array("out" => "last30days.host"))
                  ->execute();
      /*           
      while($res->hasNext()) {
        var_dump($res->getNext());
      }
      exit;
      */
  }
}

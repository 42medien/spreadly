<?php
namespace Repositories;

use Doctrine\ODM\MongoDB\DocumentRepository,
    Documents\Stats,
    \MongoDate;


abstract class StatsRepository extends DocumentRepository
{
  
  protected $GROUP_BY = "host";
  
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
  
  public function findByRange($hosts, $fromDay, $toDay) {
    // Cut off the time, in case it is coming as full datetime
    $fromDay = date('Y-m-d', strtotime($fromDay));
    $toDay = date('Y-m-d', strtotime($toDay));
    
    $query = $this->createQueryBuilder()
                  ->field('host')->in($hosts)
                  ->field("day")->range(new MongoDate(strtotime($fromDay)), new MongoDate(strtotime($toDay)))
                  ->map(
                  'function() { 
                     emit(
                       this.'.$this->GROUP_BY.', '.
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
                  }");
                  
    $cursor = $query->getQuery(array("out" => "last30days.".$this->GROUP_BY))
                    ->execute();
    return $cursor;    
  }
  
  public function findLast30($hosts) {
    $fromDay = date('Y-m-d', strtotime("30 days ago"));
    $toDay = date('Y-m-d', strtotime("today"));
    return $this->findByRange($hosts, $fromDay, $toDay);
  }
  
}

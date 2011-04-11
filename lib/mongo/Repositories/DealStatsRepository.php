<?php
namespace Repositories;

use Doctrine\ODM\MongoDB\DocumentRepository,
    Documents\Stats,
    \MongoDate;
    
class DealStatsRepository extends StatsRepository
{
  protected $GROUP_BY = "d_id";
  
  public function findByDealIds($dealIds) {    
    $query = $this->createQueryBuilder()
                  ->field('d_id')->in($dealIds)
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

}
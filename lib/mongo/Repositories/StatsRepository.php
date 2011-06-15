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
    return $this->findByHostsAndRange($hosts, $fromDay, $toDay);
  }

  public function findOnlyByRange($fromDay, $toDay) {
    // Cut off the time, in case it is coming as full datetime
    $fromDay = date('Y-m-d', strtotime($fromDay));
    $toDay = date('Y-m-d', strtotime($toDay));

    $query = $this->rangeMapReduce($fromDay, $toDay, 'day');

    $cursor = null;
    try {
      $cursor = $query->getQuery(array("out" => "last30days.".$this->GROUP_BY))
                      ->execute();
    } catch (\Exception $e) {
      \sfContext::getInstance()->getLogger()->err("{StatsRepository} findByRange failed.\n".$e->getMessage());
    }
    return $cursor;
  }
  
  public function findByHostsAndRange($hosts, $fromDay, $toDay) {
    // Cut off the time, in case it is coming as full datetime
    $fromDay = date('Y-m-d', strtotime($fromDay));
    $toDay = date('Y-m-d', strtotime($toDay));

    $query = $this->rangeMapReduce($fromDay, $toDay);
    $query->field('host')->in($hosts);

    $cursor = null;
    try {
      $cursor = $query->getQuery(array("out" => "last30days.".$this->GROUP_BY))
                      ->execute();
    } catch (\Exception $e) {
      \sfContext::getInstance()->getLogger()->err("{StatsRepository} findByRange failed.\n".$e->getMessage());
    }
    return $cursor;
  }

  public function findByUrlsAndRange($urls, $fromDay, $toDay) {
    // Cut off the time, in case it is coming as full datetime
    $fromDay = date('Y-m-d', strtotime($fromDay));
    $toDay = date('Y-m-d', strtotime($toDay));

    $query = $this->rangeMapReduce($fromDay, $toDay);
    $query->field('url')->in($urls);

    $cursor = null;
    try {
      $cursor = $query->getQuery(array("out" => "last30days.".$this->GROUP_BY))
                      ->execute();
    } catch (\Exception $e) {
      \sfContext::getInstance()->getLogger()->err("{StatsRepository} findByRange failed.\n".$e->getMessage());
    }
    return $cursor;
  }

  private function rangeMapReduce($fromDay, $toDay, $groupBy=null) {
    return $this->createQueryBuilder()
              ->field("day")->gte(new MongoDate(strtotime($fromDay)))
              ->field("day")->lte(new MongoDate(strtotime($toDay)))
              ->map(
              'function() {
                 emit(
                   this.'. ($groupBy ? $groupBy : $this->GROUP_BY) .', '.
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
  }

  public function findLast30($hosts) {
    $fromDay = date('Y-m-d', strtotime("30 days ago"));
    $toDay = date('Y-m-d', strtotime("today"));
    return $this->findByRange($hosts, $fromDay, $toDay);
  }

}

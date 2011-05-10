<?php
namespace Repositories;

use Doctrine\ODM\MongoDB\DocumentRepository,
    \MongoDate;

class PushJobRepository extends JobRepository {

  public function countValidPuSHsLast24h($domain_profile_id) {
    $from = strtotime("24 hours ago");
    // Funky mongo shit. Just need the extra second for unit tests
    $to = strtotime("now + 1 second");
    return $this->countValidPuSHs($domain_profile_id, $from, $to);
  }
  
  public function countFailedPuSHsLast24h($domain_profile_id) {
    $from = strtotime("24 hours ago");
    // Funky mongo shit. Just need the extra second for unit tests
    $to = strtotime("now + 1 second");
    return $this->countFailedPuSHs($domain_profile_id, $from, $to);
  }
  
  public function countTimeoutPuSHsLast24h($domain_profile_id) {
    $from = strtotime("24 hours ago");
    // Funky mongo shit. Just need the extra second for unit tests
    $to = strtotime("now + 1 second");
    return $this->countTimeoutPuSHs($domain_profile_id, $from, $to);
  }  
  
  /**
   * returns the number of the successfull pushes
   *
   * @param int $domain_profile_id
   * @param string $from
   * @param string $to
   * @return int
   */
  public function countValidPuSHs($domain_profile_id, $from, $to) {
    return $this->createQueryBuilder()
                ->field('type')->equals('push')
                ->field('domain_profile_id')->equals(strval($domain_profile_id))
                ->field('finished_at')->exists(true)
                ->field('error')->exists(false)
                ->field("finished_at")->gte(new MongoDate($from))
                ->field("finished_at")->lte(new MongoDate($to))
                ->getQuery()
                ->count();
  }

  /**
   * returns the number of failed pushes (except timeouts)
   *
   * @param int $domain_profile_id
   * @param string $from
   * @param string $to
   * @return int
   */
  public function countFailedPuSHs($domain_profile_id, $from, $to) {
    
    return $this->createQueryBuilder()
                ->field('type')->equals('push')
                ->field('domain_profile_id')->equals(strval($domain_profile_id))
                ->field('error')->exists(true)
                ->field('error.http_code')->notEqual(408)
                ->field("started_at")->gte(new MongoDate($from))
                ->field("started_at")->lte(new MongoDate($to))                
                ->getQuery()
                ->count();
  }

  /**
   * returns the number of time outs while pushing data
   *
   * @param int $domain_profile_id
   * @param string $from
   * @param string $to
   * @return int
   */
  public function countTimeoutPuSHs($domain_profile_id, $from, $to) {
    return $this->createQueryBuilder()
                ->field('type')->equals('push')
                ->field('domain_profile_id')->equals(strval($domain_profile_id))
                ->field('error')->exists(true)
                ->field('error.http_code')->equals(408)
                ->field("started_at")->gte(new MongoDate($from))
                ->field("started_at")->lte(new MongoDate($to))                
                ->getQuery()
                ->count();
  }
}
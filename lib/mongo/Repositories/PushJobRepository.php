<?php
namespace Repositories;

use Doctrine\ODM\MongoDB\DocumentRepository,
    \MongoDate;

class PushJobRepository extends JobRepository {

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
                ->field('finished_at')->exists(true)
                ->field('error')->exists(true)
                ->field('error.http_code')->notEqual(408)
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
                ->field('finished_at')->exists(true)
                ->field('error')->exists(true)
                ->field('error.http_code')->equals(408)
                ->getQuery()
                ->count();
  }
}
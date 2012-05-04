<?php
namespace Repositories;

use Doctrine\ODM\MongoDB\DocumentRepository;

class YiidActivityRepository extends DocumentRepository
{

  /**
   * returns the latest activities of a user (desc order by date)
   *
   * @author Matthias Pfefferle
   * @param int $pUserId
   * @param int $pLimit default = 10
   * @return array
   */
  public function findLatestByUserId($u_id, $limit = 10) {
    $results = $this->createQueryBuilder()
                    ->hydrate(true)
                    ->limit($limit)
                    ->field("u_id")->equals(intval($u_id))
                    ->field("d_id")->exists(false)
                    ->sort("c", "desc")
                    ->getQuery()->execute();

    return $results;
  }

  public function countByRange($from, $to) {
    $results = $this->createQueryBuilder()
                    ->field("c")->gte($from)
                    ->field("c")->lte($to)
                    ->getQuery()->execute();

    return $results->count();
  }

  public function countCBLByRange($from, $to) {
    $results = $this->createQueryBuilder()
                    ->field("c")->gte($from)
                    ->field("c")->lte($to)
                    ->field("cb_referer")->exists(true)
                    ->getQuery()->execute();

    return $results->count();
  }

  public function countByOnlineIdentityIds($array) {
    $results = $this->createQueryBuilder()
                    ->field("oiids")->in($array)
                    ->getQuery()->execute();

    return $results->count();
  }

  public function generateQueryByHttpQuery($params = array()) {
    $q = $this->createQueryBuilder();
    $q->limit(10);
    $q->sort(array("c" => "DESC"));

    if ($params['u_id']) {
      $q->field("u_id")->equals(intval($query['u_id']));
    }

    if ($params['s']) {
      $regexp = new \MongoRegex('/'.$params['s'].'/i');
      $q->addOr($q->expr()->field('title')->equals($regexp));
      $q->addOr($q->expr()->field('descr')->equals($regexp));
      $q->addOr($q->expr()->field('comment')->equals($regexp));
      $q->addOr($q->expr()->field('tags')->in(array($regexp)));
    }

    if ($params['o']) {
      $q->sort(array("c" => $params['o']));
    }

    if ($params['l']) {
      $q->limit($params['l']);
    }

    if ($params['t']) {
      $q->field("tags")->in(array($params['t']));
    }

    if ($params['p']) {
      if ($params['l']) {
        $limit = $params['l'];
      } else {
        $limit = 10;
      }

      $q->skip(($params['p'] - 1) * $limit);
    }

    return $q->getQuery();
  }

  public function findByQuery($params = array()) {
    return $this->generateQueryByHttpQuery($params)->execute();
  }

  public function countByQuery($params = array()) {
    return $this->generateQueryByHttpQuery($params)->count();
  }
}
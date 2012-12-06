<?php
namespace Repositories;

use Doctrine\ODM\MongoDB\DocumentRepository,
    \MongoDate;

class InterestRepository extends DocumentRepository {
	
	/**
	 * get the latest entries
	 *
	 * @param int $limit
	 * @param int $offset
	 */
	public function upsert($interest) {
    $result = $this->createQueryBuilder()
                   ->findAndUpdate()
                   ->field('o_id')->equals($interest['id'])
                   ->upsert(true)
                   ->field('name')->set($interest['name'])
                   ->field('cat')->set($interest['category'])
                   ->field('c')->set(intval(strtotime($interest['created_time'])))
                   ->getQuery()->execute();

    return $result;
	}
}
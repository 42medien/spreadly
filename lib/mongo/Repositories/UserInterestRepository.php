<?php
namespace Repositories;

use Doctrine\ODM\MongoDB\DocumentRepository,
    \MongoDate;

class UserInterestRepository extends DocumentRepository {
	
	/**
	 * get the latest entries
	 *
	 * @param int $limit
	 * @param int $offset
	 */
	public function upsert($online_identity, $interest) {
    $result = $this->createQueryBuilder()
                   ->findAndUpdate()
                   ->field('o_id')->equals($interest->getOriginalId())
									 ->field('oi_id')->equals(intval($online_identity->getId()))
                   ->upsert(true)
                   ->field('u_id')->set(intval($online_identity->getUserId()))
                   ->field('c')->set(intval($interest->getCreatedAt()))
                   ->getQuery()->execute();
		
		$result->setInterest($interest);
		$result->save();

    return $result;
	}
}
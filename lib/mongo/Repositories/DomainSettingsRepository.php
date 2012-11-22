<?php
namespace Repositories;

use Doctrine\ODM\MongoDB\DocumentRepository,
    \MongoDate;

class DomainSettingsRepository extends DocumentRepository {
	
	/**
	 * get the latest entries
	 *
	 * @param int $limit
	 * @param int $offset
	 */
	public function findOrdered($limit = 10, $offset = 0) {
    $results = $this->createQueryBuilder()
                    ->hydrate(true)
                    ->limit($limit)
										->sort("u", "desc")
                    ->getQuery()->execute();

    return $results;
	}
}
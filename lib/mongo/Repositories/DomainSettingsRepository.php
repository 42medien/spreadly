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
	public function findOrdered($limit = 10, $search = null) {
    $results = $this->createQueryBuilder()
                    ->hydrate(true)
                    ->limit($limit)
										->sort("u", "desc");
    
		if ($search) {
			$regexp = new \MongoRegex('/'.$search.'/i');
			$results->field('domain')->equals($regexp);
		}
		
    return $results->getQuery()->execute();
	}
}
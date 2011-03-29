<?php
namespace Repositories;

use Doctrine\ODM\MongoDB\DocumentRepository;

class ActivityStatsRepository extends DocumentRepository
{
    public function findOneByNinjaHostofDeath($host)
    {
        return $this->findOneBy(array('host' => $host));
    }
}
<?php
namespace Documents;

use Documents\Stats;

/**
 * @author Matthias Pfefferle
 * @author Hannes Schippmann
 *
 * @Document(collection="deal_stats.host", repositoryClass="Repositories\DealStatsRepository")
 * @HasLifecycleCallbacks
 * @InheritanceType("COLLECTION_PER_CLASS")
 */
class DealStats extends Stats {
  /** @Field(type="int" name="d_id") */
  private $deal_id;
  
  public function setDealId($deal_id) {
    $this->deal_id = $deal_id;
  }

  public function getDealId() {
    return $this->deal_id;
  }

}
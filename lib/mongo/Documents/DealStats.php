<?php
namespace Documents;

use Documents\Stats;

/**
 * @author Matthias Pfefferle
 * @author Hannes Schippmann
 *
 * @Document(collection="deal_stats.host")
 * @HasLifecycleCallbacks
 */
class DealStats extends Stats {
  /** @Field(type="int" name="d_id") */
  private $deal_id;
}
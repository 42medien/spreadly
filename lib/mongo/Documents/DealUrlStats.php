<?php
namespace Documents;

use Documents\Stats;

/**
 * @author Matthias Pfefferle
 * @author Hannes Schippmann
 *
 * @Document(collection="deal_stats.url", repositoryClass="Repositories\DealUrlStatsRepository")
 * @HasLifecycleCallbacks
 * @InheritanceType("COLLECTION_PER_CLASS")
 */
class DealUrlStats extends DealStats {
  /** @String */
  protected $url;
}

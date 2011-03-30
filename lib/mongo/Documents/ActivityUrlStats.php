<?php
namespace Documents;

use Documents\Stats;

/**
 * @author Matthias Pfefferle
 * @author Hannes Schippmann
 *
 * @Document(collection="activity_stats.url", repositoryClass="Repositories\ActivityUrlStatsRepository")
 * @HasLifecycleCallbacks
 * @InheritanceType("COLLECTION_PER_CLASS")
 */
class ActivityUrlStats extends Stats {
  /** @String */
  protected $url;
}
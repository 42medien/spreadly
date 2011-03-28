<?php
namespace Documents;

use Documents\Stats;

/**
 * @author Matthias Pfefferle
 * @author Hannes Schippmann
 *
 * @Document(collection="activity_stats.url")
 * @HasLifecycleCallbacks
 */
class ActivityUrlStats extends Stats {
  /** @String */
  private $url;
}
<?php
namespace Documents;

use Documents\Stats;

/**
 * @author Matthias Pfefferle
 * @author Hannes Schippmann
 *
 * @Document(collection="deal_stats.url")
 * @HasLifecycleCallbacks
 */
class DealUrlStats extends DealStats {
  /** @String */
  private $url;
}
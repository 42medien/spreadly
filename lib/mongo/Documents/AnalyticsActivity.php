<?php
namespace Documents;

use Documents\Stats;

/**
 * @author Matthias Pfefferle
 * @author Hannes Schippmann
 *
 * @Document(collection="activity_stats.host", repositoryClass="Repositories\ActivityStatsRepository")
 * @HasLifecycleCallbacks
 * @InheritanceType("COLLECTION_PER_CLASS")
 */
class AnalyticsActivity extends Stats {

  /** @String */
  private $relationship;

  /** @Int */
  private $user_id;

  /** @Int */
  private $yiid_activity_id;

  /** @String */
  private $gender;
  
}
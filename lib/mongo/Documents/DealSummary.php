<?php
namespace Documents;

use Documents\Stats;

/**
 * @author Matthias Pfefferle
 * @author Hannes Schippmann
 *
 * @Document(collection="deal_summary.host", repositoryClass="Repositories\DealSummaryRepository")
 * @HasLifecycleCallbacks
 * @InheritanceType("COLLECTION_PER_CLASS")
 */
class DealSummary extends Summary {
  /** @Field(type="int", name="d_id") */
  protected $deal_id;
}
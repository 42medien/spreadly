<?php
namespace Documents;

use Documents\Stats;

/**
 * @author Matthias Pfefferle
 * @author Hannes Schippmann
 *
 * @Document(collection="deal_summary.url", repositoryClass="Repositories\DealUrlSummaryRepository")
 * @HasLifecycleCallbacks
 * @InheritanceType("COLLECTION_PER_CLASS")
 */
class DealUrlSummary extends Summary {
  /** @String */
  protected $url;

  /** @Field(type="int", name="d_id") */
  protected $deal_id;
}

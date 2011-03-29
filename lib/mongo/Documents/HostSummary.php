<?php
namespace Documents;

use Documents\Summary;

/**
 * @author Matthias Pfefferle
 * @author Hannes Schippmann
 *
 * @Document(collection="summary.host", repositoryClass="Repositories\HostSummaryRepository")
 * @HasLifecycleCallbacks
 * @InheritanceType("COLLECTION_PER_CLASS")
 */
class HostSummary extends Summary {
  
}
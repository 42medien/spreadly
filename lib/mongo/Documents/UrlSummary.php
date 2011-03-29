<?php
namespace Documents;

use Documents\Summary;

/**
 * @author Matthias Pfefferle
 * @author Hannes Schippmann
 *
 * @Document(collection="summary.url", repositoryClass="Repositories\UrlSummaryRepository")
 * @HasLifecycleCallbacks
 * @InheritanceType("COLLECTION_PER_CLASS")
 */
class UrlSummary extends Summary {

  /** @String */
  private $url;
  
  public function setUrl($url) {
    $this->url = $url;
  }

  public function getUrl() {
    return $this->url;
  }
}

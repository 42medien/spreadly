<?php
namespace Documents;

use \MongoDate;
    
/**
 * Base Class for scheduled Jobs in the Queue
 * @author Hannes Schippmann
 *
 * @MappedSuperclass
 * @Document(collection="jobs", repositoryClass="Repositories\JobRepository")
 * @HasLifecycleCallbacks
 * @InheritanceType("SINGLE_COLLECTION")
 * @DiscriminatorField(fieldName="type")
 * @DiscriminatorMap({"contact_import"="ContactImportJob"})
 */
abstract class Job extends BaseDocument {
  private const DEFAULT_PRIORITY = 1;
  
  /** @Id */
  protected $id;

  /** @Boolean */
  protected $scheduled;

  /** @Date */
  protected $scheduled_at;
  
  /** @Date */
  protected $started_at;

  /** @Date */
  protected $finished_at;
  
  /** @Int */
  protected $priority;

  /**
   * The execute function, that gets called by the workers
   */
  abstract public function execute();
  
  /**
   * pre-save hook
   *
   * @PrePersist
   *
   * @author Hannes Schippmann
   */
  public function prePersist() {
    $this->setScheduled(true);
    $this->setScheduledAt(new MongoDate());
    if(!$this->getPriority()) {
      $this->setPriority(self::DEFAULT_PRIORITY);
    }
  }
}

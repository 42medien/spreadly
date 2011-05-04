<?php
namespace Documents;

use \MongoDate,
    \MongoManager;

/**
 * Base Class for scheduled Jobs in the Queue
 * @author Hannes Schippmann
 *
 * @MappedSuperclass
 * @Document(collection="jobs", repositoryClass="Repositories\JobRepository")
 * @HasLifecycleCallbacks
 * @InheritanceType("SINGLE_COLLECTION")
 * @DiscriminatorField(fieldName="type")
 * @DiscriminatorMap({"contact_import"="ContactImportJob", "pointless"="PointlessJob", "push"="PushJob"})
 */
abstract class Job extends BaseDocument {
  const DEFAULT_PRIORITY = 1;

  /** @Id */
  protected $id;

  /** @Int */
  protected $priority;

  /** @Boolean */
  protected $scheduled;

  /** @Int */
  protected $schedule_count;

  /** @Date */
  protected $scheduled_at;

  /** @Date */
  protected $started_at;

  /** @Date */
  protected $finished_at;

  /** @String */
  protected $error;

  /**
   * The execute function, that gets called by the workers
   * @throws an Exception in case of an error
   */
  abstract public function execute();

  /**
   * The finished function should be called by the worker process after execute is successfully finished
   */
  public function finished() {
    $this->setFinishedAt(new MongoDate());
    $dm = MongoManager::getDM();
    $dm->persist($this);
    $dm->flush();
  }

  /**
   * The reschedule function should be called by the worker process if the job has to reenter the queue, i.e. in case of an error
   * @param The reason why this job has to be rescheduled. Probably because of some kind of error.
   */
  public function reschedule($error) {
    $this->setError($error);
    $this->setFinishedAt(null);
    $this->setScheduled(true);
    $cnt = $this->getScheduleCount();
    $this->setScheduleCount(++$cnt);
    $this->setScheduledAt(new MongoDate());

    $dm = MongoManager::getDM();
    $dm->persist($this);
    $dm->flush();
  }

  /**
   * Sets some things before the job is persisted
   *
   * @PrePersist
   */
  public function prePersist() {
    $this->setScheduled(true);
    $this->setScheduleCount(1);
    $this->setScheduledAt(new MongoDate());
    if(!$this->getPriority()) {
      $this->setPriority(self::DEFAULT_PRIORITY);
    }
  }
}

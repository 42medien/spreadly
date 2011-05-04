<?php
namespace Documents;

use Documents\Job;

/**
 * Push API Job
 *
 * @Document
 * @author Matthias Pfefferle
 */
class PushJob extends Job {
  /** @String */
  protected $yiid_activity_id;

  public function __construct($yiid_activity_id) {
    $this->yiid_activity_id = $yiid_activity_id;
  }

  /**
   * send notification
   */
  public function execute() {
    /*$dm = MongoManager::getDM();

    $ya = $dm->getRepository("Documents\YiidActivity")->find(new MongoId($this->getYiidActivityId()));

    if ($ya) {
      json_encode($ya->toSimpleActivityArray());
    } else {
      // some error management
    }*/
  }
}
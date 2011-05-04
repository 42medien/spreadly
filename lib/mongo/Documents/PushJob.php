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
    $dm = \MongoManager::getDM();
    $ya = $dm->getRepository("Documents\YiidActivity")->find(new \MongoId($this->getYiidActivityId()));
    $dp = $ya->getDomainProfile();

    if (!$dp) {
      return false;
    }

    $ds = $dp->getDomainSubscriptions();

    foreach ($ds as $s) {
      \PubSubHubbub::push($s->getCallback(), json_encode($ya->toSimpleActivityArray()), array("Content-Type: application/json"));
    }
  }
}
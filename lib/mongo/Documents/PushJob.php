<?php
namespace Documents;

use Documents\Job;

/**
 * Push API Job
 *
 * @Document(collection="jobs", repositoryClass="Repositories\PushJobRepository")
 * @author Matthias Pfefferle
 */
class PushJob extends Job {
  /** @String */
  protected $yiid_activity_id;

  /** @String */
  protected $domain_profile_id;

  public function __construct($yiid_activity_id, $domain_profile_id) {
    $this->yiid_activity_id = $yiid_activity_id;
    $this->domain_profile_id = $domain_profile_id;
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
      $info = \PubSubHubbub::push($s->getCallback(), $this->toJson($ya), array("Content-Type: application/json"));

      // all good -- anything in the 200 range
      if (substr($info['http_code'],0,1) == "2") {
        $this->finished();
      } elseif ($info['http_code'] == 408) {
        $this->reschedule(array("code" => 408, "message" => "Server Timeout"));
      } else {
        $this->failed(array("code" => $info['http_code'], "message" => "PuSH failed"));
      }
    }
  }

  private function toJson($ya) {
    $dp = $ya->getDomainProfile();

    $as = array();

    $as['generator'] = array("url" => "http://spreadly.com/");
    $as['published'] = date("c", $ya->getC());
    $as['verb'] = "like";
    $as['object'] = array("objectType" => "website",
                          "url" => $ya->getUrl(),
                          "id" => $ya->getUniqueId());
    $as['target'] = array("objectType" => "service",
                          "url" => $dp->getDomain(),
                          "host" => $dp->getUrl(),
                          "id" => $dp->getUniqueId());

    return json_encode($as);
  }
}
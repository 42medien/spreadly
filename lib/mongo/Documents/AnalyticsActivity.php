<?php
namespace Documents;

use Documents\Stats;

/**
 * @author Matthias Pfefferle
 * @author Hannes Schippmann
 *
 * @Document(collection="analytics_activity", repositoryClass="Repositories\AnalyticsActivityRepository")
 * @HasLifecycleCallbacks
 * @InheritanceType("COLLECTION_PER_CLASS")
 */
class AnalyticsActivity extends Stats {

  /** @Field(type="string", name="rel") */
  protected $relationship;

  /** @Field(type="int", name="u_id") */
  protected $user_id;

  /** @Field(type="string", name="ya_id") */
  protected $yiid_activity_id;

  /** @Field(type="string", name="cbl_ya_id") */
  protected $clickback_like_yiid_activity_id;

  /** @Field(type="int", name="d_id") */
  protected $deal_id;

  /** @Date */
  protected $date;

  /** @String */
  protected $title;

  /** @String */
  protected $gender;

  /** @String */
  protected $zip;

  /** @String */
  protected $url;

  /** @String */
  protected $age;

  /** @Int */
  protected $hour_of_day;

  public function getYiidActivity() {
    $dm = \MongoManager::getDM();
    return $dm->getRepository("Documents\YiidActivity")->find(new \MongoId($this->getYiidActivityId()));
  }

  public function getNetworkWithMostClickbacks() {
    $service = "-";
    $count = 0;
    foreach ($this->getServices() as $key => $value) {
      if ($value["cb"] > $count) {
        $service = $key;
        $count = $value["cb"];
      }
    }

    return $service;
  }
  
  /**
   * lazy loads the user connected to this activity
   *
   * @return User
   */
  public function getUser() {
    $lUser = \UserTable::getInstance()->retrieveByPk($this->getUserId());

    return $lUser;
  }
}
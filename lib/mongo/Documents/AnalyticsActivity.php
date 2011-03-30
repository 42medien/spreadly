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
  private $relationship;

  /** @Field(type="int", name="u_id") */
  private $user_id;

  /** @Field(type="int", name="ya_id") */
  private $yiid_activity_id;

  /** @String */
  private $gender;
  
  /** @String */
  private $zip;

  /** @String */
  private $url;
}
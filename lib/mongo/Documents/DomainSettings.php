<?php
namespace Documents;

use \MongoDate,
    \MongoManager;

/**
 * Base Class for scheduled Jobs in the Queue
 *
 * @author Matthias Pfefferle
 *
 * @Document(collection="domain_settings", repositoryClass="Repositories\DomainSettingsRepository")
 * @HasLifecycleCallbacks
 * @InheritanceType("SINGLE_COLLECTION")
 */
class DomainSettings extends BaseDocument {

  /** 
   * @Id
   */
  protected $id;

  /**
   * The DomainProfile ID
   * 
   * @Int
   */
  protected $domain_profile_id;
  
  /**
   * The host (without protocol)
   *
   * @String
   */ 
  protected $domain;
  
  /**
   * The time in minutes
   *
   * @Int
   */
  protected $mute;
  
  /**
   * Disables advertising
   *
   * @Boolean
   */
  protected $enable_ads;
  
  /**
   * Defines how to display the ad
   *
   * @String
   */
  protected $ad_displayer;
  
  /**
   * Last changes to the object
   *
   * @Field(type="int", name="u")
   */
  protected $updated_at;
	
  /**
   * A nicer way to save the object
   */
  public function save() {
		$this->setUpdatedAt(strtotime("now"));
    $dm = MongoManager::getDM();
    $dm->persist($this);
    $dm->flush();
  }
}
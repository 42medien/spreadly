<?php
namespace Documents;

use \MongoDate,
    \MongoManager;

/**
 * Base Class for scheduled Jobs in the Queue
 *
 * @author Matthias Pfefferle
 *
 * @Document(collection="domain_settings")
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
  protected $disable_ads;
  
  /**
   * Last changes to the object
   *
   * @Date
   */
  protected $updated_at;

  
  /**
   * A nicer way to save the object
   */
  public function save() {
    $dm = MongoManager::getDM();
    $dm->persist($this);
    $dm->flush();
  }
}

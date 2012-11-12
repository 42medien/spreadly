<?php
namespace Documents;

use \MongoDate,
    \MongoManager;

/**
 * Base Class for scheduled Jobs in the Queue
 *
 * @author Matthias Pfefferle
 *
 * @HasLifecycleCallbacks
 * @InheritanceType("SINGLE_COLLECTION")
 */
abstract class Advertisement extends BaseDocument {

  /** 
   * @Id
   */
  protected $id;

  /**
   * The Domain Profile ID
   * 
   * @Int
   */
  protected $domain_profile_id;
  
  /**
   * The url to an advertisement image
   *
   * @String
   */
  protected $ad_image;
  
  /**
   * A link to the advertisement page
   *
   * @String
   */
  protected $ad_link;
  
  /**
   * Any HTML-snippet
   *
   * @String
   */
  protected $ad_code;
  
  /**
   * Last changes to the object
   *
   * @Date
   */
  protected $updated_at;
  
  /**
   * The date where the advertisement should show up 
   *
   * @Date
   */
  protected $starting_at;
  
  /**
   * A nicer way to save the object
   */
  public function save() {
    $dm = MongoManager::getDM();
    $dm->persist($this);
    $dm->flush();
  }
}

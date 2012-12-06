<?php
namespace Documents;

use \MongoDate,
    \MongoManager;

/**
 * Base Class to represent Interests
 *
 * @author Matthias Pfefferle
 *
 * @HasLifecycleCallbacks
 * @InheritanceType("SINGLE_COLLECTION")
 * @Document(collection="interests", repositoryClass="Repositories\InterestRepository")
 */
class Interest extends BaseDocument {

  /** 
   * @Id
   */
  protected $id;

  /** 
   * @Field(type="string", name="o_id")
   */
  protected $original_id;
  
  /** 
   * @String
   */
  protected $name;
	
  /** 
	 * @Field(type="string", name="cat")
   */
  protected $category;
	
  /**
	 * @Field(type="int", name="c")
   */
  protected $created_at;
	
  /**
   * A nicer way to save the object
   */
  public function save() {
    $dm = MongoManager::getDM();
    $dm->persist($this);
    $dm->flush();
  }
}

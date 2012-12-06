<?php
namespace Documents;

use \MongoDate,
    \MongoManager;

/**
 * Base Class to connect the user with his Interests
 *
 * @author Matthias Pfefferle
 *
 * @HasLifecycleCallbacks
 * @InheritanceType("SINGLE_COLLECTION")
 * @Document(collection="user_interests", repositoryClass="Repositories\UserInterestRepository")
 */
class UserInterest extends BaseDocument {

  /** 
   * @Id
   */
  protected $id;
	
  /**
	 * @ReferenceOne(targetDocument="Documents\Interest", cascade="all")
	 */
  protected $interest;
	
  /** 
   * @Field(type="string", name="o_id")
   */
  protected $original_id;
  
	/**
	 * @Field(type="int", name="oi_id")
	 */
	protected $online_identity_id;
	
	/**
	 * @Field(type="int", name="u_id")
	 */
	protected $user_id;
	
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
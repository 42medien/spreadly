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
 * @Document(collection="user_rank", repositoryClass="Repositories\UserRankRepository")
 */
class UserRank extends BaseDocument {

  /** 
   * @Id
   */
  protected $id;

  /** 
   * @Field(type="int", name="u_id")
   */
  protected $user_id;
  
  /** 
   * @Field(type="int", name="r")
   */
  protected $rank;
	
  /** 
   * @Field(type="int", name="m")
   */
  protected $month;
  
  /** 
   * @Field(type="int", name="d")
   */
  protected $day;
  
  /** 
   * @Field(type="int", name="y")
   */
  protected $year;
  
  /**
	 * @Field(type="int", name="c")
   */
  protected $created_at;
	
  /**
   * pre-save hook
   *
   * @PrePersist
   */
  public function prePersist() {
    $this->setCreatedAt((strtotime("now")));
    $this->setDay(intval(date("d")));
    $this->setMonth(intval(date("m")));
    $this->setYear(intval(date("Y")));
  }
  
  /**
   * A nicer way to save the object
   */
  public function save() {
    $dm = MongoManager::getDM();
    $dm->persist($this);
    $dm->flush();
  }
}
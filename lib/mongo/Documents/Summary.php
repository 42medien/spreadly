<?php
namespace Documents;

/**
 * @author Matthias Pfefferle
 * @author Hannes Schippmann
 *
 * @MappedSuperclass
 */
abstract class Summary extends BaseDocument {
  /** @Id */
  protected $id;

  /** @Field(type="int", name="l") */
  protected $likes;

  /** @Field(type="int", name="mp") */
  protected $media_penetration;

  /** @Field(type="int", name="cb") */
  protected $clickbacks;
  
  /** @Field(type="int", name="cbl") */
  protected $clickback_likes;
  
  /** @String */
  protected $host;
}

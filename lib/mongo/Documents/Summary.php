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

  /** @Field(type="int", name="cb") */
  protected $clickbacks;

  /** @Int */
  protected $likes;

  /** @String */
  protected $host;
}
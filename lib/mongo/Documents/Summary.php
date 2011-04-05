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

  /**
   * @Field(type="hash", name="d")
   *
   * for example:
   *
   * [d] => Array
   *     (
   *         [age] => Array
   *             (
   *                 [b_18_24] => 4
   *                 [b_25_34] => 9
   *                 [b_35_54] => 6
   *                 [o_55] => 1
   *                 [u_18] => 6
   *             )
   *
   *        [rel] => Array
   *            (
   *                [compl] => 3
   *                [eng] => 0
   *                [ior] => 6
   *                [mar] => 0
   *                [rel] => 8
   *                [singl] => 20
   *                [u] => 3
   *                [wid] => 1
   *            )
   *
   *        [sex] => Array
   *            (
   *                [f] => 5
   *                [m] => 4
   *                [u] => 5
   *            )
   *    )
   */
  protected $demographics;
}

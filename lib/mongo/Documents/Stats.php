<?php
namespace Documents;

/**
 * @author Matthias Pfefferle
 * @author Hannes Schippmann
 *
 * @MappedSuperclass
 */
abstract class Stats extends BaseDocument {
  /** @Id */
  protected $id;

  /** @Date */
  protected $day;

  /** @String */
  protected $host;

  /** @Field(type="int", name="l") */
  protected $likes;

  /** @Field(type="int", name="mp") */
  protected $media_penetration;

  /** @Field(type="int", name="cb") */
  protected $clickbacks;

  /** @Field(type="int", name="cbl") */
  protected $clickback_likes;

  /**
   * @Field(type="hash", name="s")
   *
   * for example:
   *
   * [s] => Array
   *    (
   *        [twitter] => Array
   *            (
   *                [l] => 16
   *                [mp] => 1040
   *                [cb] => 123
   *                [cbl] => 2
   *            )
   *    )
   */
  protected $services;

  /**
   * @Field(type="hash", name="t")
   *
   * for example
   *
   * [t] => Array
   *    (
   *        [affen] => Array
   *            (
   *                [l] => 16
   *                [mp] => 1040
   *                [cb] => 123
   *                [cbl] => 2
   *            )
   *    )
   */
  protected $tags;

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

  /**
   * @Field(type="hash", name="h")
   *
   * [h] => Array
   *     (
   *         [0] => 133
   *         [1] => 34
   *         [2] => 56
   *         [3] => 8
   *         [4] => 30
   *         [...] => 12
   *         [24] => 14
   *    )
   */
  protected $likes_by_hour;
}
<?php
namespace Documents;

/**
 * @author Matthias Pfefferle
 * @author Hannes Schippmann
 */
class Stats {
  /** @Id */
  private $id;

  /** @Date */
  private $day;

  /** @String */
  private $host;

  /** @Int */
  private $likes;

  /**
   * @Field(type="hash" name="s")
   *
   * for example:
   *
   * [s] => Array
   *    (
   *        [twitter] => Array
   *            (
   *                [cb] => 4
   *                [mp] => 1040
   *                [l] => 16
   *            )
   *    )
   */
  private $services;

  /**
   * @Field(type="hash" name="t")
   *
   * for example
   *
   * [t] => Array
   *    (
   *        [affen] => Array
   *            (
   *                [cb] => 9
   *                [mp] => 810
   *                [l] => 14
   *            )
   *    )
   */
  private $tags;

  /**
   * @Field(type="hash" name="d")
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
  private $demographics;

  /**
   * @Field(type="collection" name="h")
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
  private $likes_by_hour;
}
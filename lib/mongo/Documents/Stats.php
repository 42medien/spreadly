<?php
namespace Documents;

/**
 * @author Matthias Pfefferle
 * @author Hannes Schippmann
 *
 * @MappedSuperclass
 */
abstract class Stats extends BaseDocument {
  private static $SERVICE_BASE      = 's';
  private static $DEMOGRAPHIC_BASE  = 'd';
  
  private static $SERVICE_KEYS      = array("facebook", "twitter", "linkedin", "google");
  private static $DEMOGRAPHIC_KEYS  = array("sex", "age", "rel");
  
  private static $SERVICE_DATA_KEYS = array("l", "sh", "mp", "cb", "cbl");
  private static $GENDER_KEYS       = array("m", "f", "u");
  private static $AGE_KEYS          = array("u_18", "b_18_24", "b_25_34", "b_35_54", "o_55");
  private static $RELATIONSHIP_KEYS = array("singl", "eng", "compl", "mar", "rel", "ior", "wid", "u");

  public static function toBaseMap($initial=0, $includePath=false) {
      $res = array();
      foreach (self::$SERVICE_DATA_KEYS as $key) {
        $res[$key] = ($includePath ? $initial."['$key']" : $initial);
      }
      
      #$res['likes_by_hour'] = array();
      return $res;
  }
  
  public static function toServiceMap($initial=0, $includePath=false) {
    $res = array();
    foreach (self::$SERVICE_KEYS as $baseKey) {
      foreach (self::$SERVICE_DATA_KEYS as $key) {
        $res[self::$SERVICE_BASE][$baseKey][$key] = ($includePath ? $initial.".".self::$SERVICE_BASE.".$baseKey.$key" : $initial);
      }
    }
    return $res;
  }

  public static function toDemographicsMap($initial=0, $includePath=false) {
    $res = array();
    foreach (self::$GENDER_KEYS as $key) {
      $res[self::$DEMOGRAPHIC_BASE][self::$DEMOGRAPHIC_KEYS[0]][$key] = 
        ($includePath ? $initial."['".self::$DEMOGRAPHIC_BASE."']['".self::$DEMOGRAPHIC_KEYS[0]."']['$key']" : $initial);
    }
    foreach (self::$AGE_KEYS as $key) {
      $res[self::$DEMOGRAPHIC_BASE][self::$DEMOGRAPHIC_KEYS[1]][$key] = 
        ($includePath ? $initial."['".self::$DEMOGRAPHIC_BASE."']['".self::$DEMOGRAPHIC_KEYS[1]."']['$key']" : $initial);
    }
    foreach (self::$RELATIONSHIP_KEYS as $key) {
      $res[self::$DEMOGRAPHIC_BASE][self::$DEMOGRAPHIC_KEYS[2]][$key] = 
        ($includePath ? $initial."['".self::$DEMOGRAPHIC_BASE."']['".self::$DEMOGRAPHIC_KEYS[2]."']['$key']" : $initial);
    }    
    return $res;
  }
  
  public static function toMap($initial=0, $includePath=false) {
    return array_merge(self::toBaseMap($initial, $includePath), self::toServiceMap($initial, $includePath), self::toDemographicsMap($initial, $includePath));
  }
  
  public static function toJsonMap($initial=0, $includePath=false) {
    return json_encode(self::toMap($initial, $includePath));
  }
  
  public static function toBaseSumString($sumVar='sum', $valueVar='values[i]') {
    $res = "\n";
    foreach (self::toBaseMap() as $key => $value) {
      $res .= "if(".$valueVar."['$key']) {\n";
      $res .= "  ".$sumVar."['$key'] += ".$valueVar."['$key'];\n";
      $res .= "}\n";
    }
    return $res;
  }

  public static function toDemographicsSumString($sumVar='sum', $valueVar='values[i]') {
    return self::to3rdLevelSumString(self::toDemographicsMap(), $sumVar, $valueVar);
  }

  public static function toServicesSumString($sumVar='sum', $valueVar='values[i]') {
    return self::to3rdLevelSumString(self::toServiceMap(), $sumVar, $valueVar);
  }
  
  private static function to3rdLevelSumString($map, $sumVar='sum', $valueVar='values[i]') {
    $res = "\n";
    foreach ($map as $baseKey => $base) {
      foreach ($base as $key => $values) {
        foreach ($values as $valueKey => $value) {
          $theValue = $valueVar."['$baseKey']['$key']['$valueKey']";
          $res .= "if(".$theValue.") {\n";
          $res .= "  ".$sumVar."['$baseKey']['$key']['$valueKey'] += ".$theValue.";\n";
          $res .= "}\n";
        }
      }
    }
    return $res;
  }
  
  
  /** @Id */
  protected $id;

  /** @Date */
  protected $day;

  /** @String */
  protected $host;

  /** @Field(type="int", name="l") */
  protected $likes;

  /** @Field(type="int", name="sh") */
  protected $shares;

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
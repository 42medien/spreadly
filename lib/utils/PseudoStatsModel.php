<?php
/**
 * some kind of a mongo model... it returns an array of default values
 *
 * @author Matthias Pfefferle
 */
class PseudoStatsModel {
  public static $age          = array("u_18", "b_18_24", "b_25_34", "b_35_54", "o_55");
  public static $gender       = array("m", "f", "u");
  public static $relationship = array("singl", "eng", "compl", "mar", "rel", "ior", "wid", "u");

  /**
   * prefilles an array with "0"s
   *
   * @param array $array
   * @return array
   */
  public static function prefillArray($array) {
    $result = array();
    foreach ($array as $value) {
      $result[$value] = 0;
    }
    return $result;
  }

  /**
   * returns a nulled array with all possible date fields
   *
   * @return array
   */
  public static function getPrefilledAgeArray() {
    return self::prefillArray(self::$age);
  }

  /**
   * returns a nulled array with all possible date fields
   *
   * @return array
   */
  public static function getPrefilledGenderArray() {
    return self::prefillArray(self::$gender);
  }

  /**
   * returns a nulled array with all possible date fields
   *
   * @return array
   */
  public static function getPrefilledRelationshipArray() {
    return self::prefillArray(self::$relationship);
  }
}
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
  public static $activities   = array("likes" => "pos", "dislikes" => "neg", "clickbacks" => "cb", "contacts" => "cnt");
  
  public static $services     = array("facebook", "twitter", "linkedin", "google");
  public static $demografics  = array("age" => "age", "gender" => "sex", "relationship" => "rel");
  
  /**
   * prefilles an array with "0"s
   *
   * @param array $array
   * @return array
   */
  private static function prefillArray($array) {
    $result = array();
    foreach ($array as $values) {
      $result[$values] = 0;
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

  /**
   * returns a nulled array with all possible date fields
   *
   * @return array
   */
  public static function getPrefilledActivitiesArray() {
    return self::prefillArray(array_keys(self::$activities));
  }

  /**
   * returns a nulled array with all possible date fields
   *
   * @return array
   */
  public static function getDemograficsKeys($demo) {
    switch ($demo) {
      case 'age': return self::$age; break;
      case 'gender': return self::$gender; break;
      case 'relationship': return self::$relationship; break;
      default: return null; break;
    }
  }  

  /**
   * returns a nulled array with all possible date fields
   *
   * @return array
   */
  public static function getPrefilledDemograficsArray($demo) {
    switch ($demo) {
      case 'age': return self::getPrefilledAgeArray(); break;
      case 'gender': return self::getPrefilledGenderArray(); break;
      case 'relationship': return self::getPrefilledRelationshipArray(); break;
      default: return null; break;
    }
  }  
}

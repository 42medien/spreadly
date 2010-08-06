<?php

class HydrationUtils {

/**
 * takes an returned array from an doctirne query (multi-level-array)
 * @author weyandch
 * @param array() $pArray
 */
  public static function flattenArray($pArray) {
    $lFlatted = array();
    foreach ($pArray as $value) {
      $lFlatted[] = $value[0];
    }
    return $lFlatted;
  }


}
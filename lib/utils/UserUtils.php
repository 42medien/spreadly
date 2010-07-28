<?php

/**
 *
 * @author christian
 *
 */
class UserUtils {

  /**
   *
   * @author Christian Weyand
   * @param $pUsername
   * @return unknown_type
   */
  public static function getUniqueUsername($pUsername) {
    $lUniqueName = $pUsername;
    $lCounter = 1;
    while ($lUser = UserTable::retrieveByUsername($lUniqueName)) {
      $lUniqueName = $pUsername.$lCounter;
      $lCounter++;
    }
    return $lUniqueName;
  }
}
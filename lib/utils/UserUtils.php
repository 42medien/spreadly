<?php

/**
 *
 * @author christian
 *
 */
class UserUtils {

  /**
   * generates an username, ensuring it's unique by appending a counter
   *
   * @author Christian Weyand
   * @param string $pUsername
   * @return string
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
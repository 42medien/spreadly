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
    while ($lUser = UserPeer::retrieveByUsername($lUniqueName)) {
      $lUniqueName = $pUsername.$lCounter;
      $lCounter++;
    }
    return $lUniqueName;
  }




  /**
   *
   * @author Christian Weyand
   * @return string
   */
  public static function extractUsernameFromIdentifier($pProvider, $pProfile) {
    if ($pProvider == "Google") {
      $lEmailParts = split("@", $pProfile['email']);
      $lIdentifier = $lEmailParts[0];
    } elseif ($pProvider == "Facebook") {
      $lIdentifier = $pProfile['url'];
    } elseif (array_key_exists('url', $pProfile)) {

      $lIdentifier = OnlineIdentityPeer::determineIdentifier($pProfile['url']);
      $lIdentifier = $lIdentifier['identifier'];
    }
    return $lIdentifier;
  }

}
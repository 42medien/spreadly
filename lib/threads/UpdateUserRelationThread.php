<?php
/**
 * thread to start the online-identity-update-script
 *
 * @author Christian WEyand
 */
class UpdateUserRelationThread extends Thread {

  protected $aScriptPath = 'updateUserRelation.php';

  /**
   * starts a background process which tries to import an avatar from gravatar
   *
   * @param int $pUserId
   */
  public function __construct($pUserId) {
    $this->startThread(array($pUserId));
  }
}
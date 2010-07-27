<?php

/**
 * OnlineIdentityCon
 *
 * This class has been auto-generated by the Doctrine ORM Framework
 *
 * @package    yiid
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class OnlineIdentityCon extends BaseOnlineIdentityCon
{

  public function postInsert($event) {
    // the user adds a new OI to his account
    $lUsers = $this->getOnlineIdentityFrom()->getConnectedUsers();
    $lContactUserIds = $this->getOnlineIdentityTo()->getConnectedUserIds();
    foreach ($lUsers as $lUser) {
      $lUser->updateContacts($lContactUserIds, array($this->getToId()));
    }

  }
}

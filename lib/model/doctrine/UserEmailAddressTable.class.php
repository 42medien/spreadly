<?php


class UserEmailAddressTable extends Doctrine_Table
{

  public static function getInstance() {
        return Doctrine_Core::getTable('UserEmailAddress');
  }

  public static function getMainAddresses($pUserId) {
    $lQ = Doctrine_Query::create()
    ->from('UserEmailAddress ue')
    ->where('ue.user_id = ?', $pUserId)
    ->addWhere('ue.main = ?', true);

    $lEmail = $lQ->fetchOne();
    $lQ->free();
    return $lEmail;
  }
}
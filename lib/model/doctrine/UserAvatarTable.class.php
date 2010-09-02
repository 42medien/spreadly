<?php


class UserAvatarTable extends Doctrine_Table
{

  public static function getInstance()
  {
    return Doctrine_Core::getTable('UserAvatar');
  }


  /**
   * retrieves main avatar for a given user
   * @param $pUserId
   */
  public static function getMainAvatarForUserId($pUserId) {
    $lQ = Doctrine_Query::create()
    ->from('UserAvatar ua')
    ->where('ua.user_id = ?', $pUserId)
    ->addWhere('ua.is_main = ?', true);

    return $lQ->fetchOne();
  }

  public static function getAvatarForName($pUserId, $pName){
    $lQ = Doctrine_Query::create()
    ->from('UserAvatar ua')
    ->where('ua.user_id = ?', $pUserId)
    ->addWhere('ua.avatar = ?', $pName);

    return $lQ->fetchOne();

  }

}
<?php


class DomainProfileTable extends Doctrine_Table
{
  const STATE_PENDING = 'pending';
  const STATE_VERIFIED = 'verified';

  public static function getInstance()
  {
      return Doctrine_Core::getTable('DomainProfile');
  }

  public static function retrieveVerifiedForUser($pUser) {
    $lQ = DomainProfileTable::getInstance()->createQuery()
    ->where('state = ?', DomainProfileTable::STATE_VERIFIED)
    ->andWhere('sf_guard_user_id = ?', $pUser->getId())
    ->orderBy('created_at DESC');
    return $lQ->execute();
  }

  public static function retrieveAllForUser($pUser) {
    $lQ = DomainProfileTable::getInstance()->createQuery()
    ->where('sf_guard_user_id = ?', array($pUser->getId()))
    ->orderBy('created_at DESC');
    return $lQ->execute();
  }
}

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

  public function countByRange($from, $to) {
    $fromDate = date('c', $from);
    $toDate = date('c', $to);

    $lQuery = $this->createQuery()
                   ->where('created_at BETWEEN ? AND ?', array($fromDate, $toDate))
                   ->execute();

    return $lQuery->count();
  }

  public function retrieveByUrl($url) {
    $host = parse_url($url, PHP_URL_HOST);

    return $this->createQuery()
                ->where('url = ?', array($host))
                ->andWhere('state = ?', array('verified'))
                ->fetchOne();
  }

  public function countVerifiedByRange($from, $to) {
    $fromDate = date('c', $from);
    $toDate = date('c', $to);

    $lQuery = $this->createQuery()
                   ->where('created_at BETWEEN ? AND ?', array($fromDate, $toDate))
                   ->andWhere('state = ?', 'verified')
                   ->execute();

    return $lQuery->count();
  }
}

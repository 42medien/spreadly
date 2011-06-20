<?php


class sfGuardUserTable extends PluginsfGuardUserTable
{

  public static function getInstance()
  {
        return Doctrine_Core::getTable('sfGuardUser');
  }

  public function countByRange($from, $to) {
    $fromDate = date('c', $from);
    $toDate = date('c', $to);

    $lQuery = $this->createQuery()
                     ->where('created_at BETWEEN ? AND ?', array($fromDate, $toDate))
                     ->execute();

    return $lQuery->count();
  }
}
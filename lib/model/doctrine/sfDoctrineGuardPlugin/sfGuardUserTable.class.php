<?php


class sfGuardUserTable extends PluginsfGuardUserTable
{
    
  public static function getInstance()
  {
        return Doctrine_Core::getTable('sfGuardUser');
  }
    
  public function countByRange($from, $to) {
    $fromDate = date('Y-m-d', $from);
    $toDate = date('Y-m-d', $to);
    
    $lQuery = $this->createQuery()
                     ->where('created_at BETWEEN ? AND ?', array($fromDate, $toDate))
                     ->execute();

    return $lQuery->count();
  }
}
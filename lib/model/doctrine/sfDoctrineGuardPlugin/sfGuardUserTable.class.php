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

  /**
   * generates an username, ensuring it's unique by appending a counter
   *
   * @author Christian Weyand
   * @param string $pUsername
   * @return string
   */
  public function getUniqueUsername($pUsername) {
    $lUniqueName = $pUsername;
    $lCounter = 1;
    while ($lUser = $this->findOneBy("username", $lUniqueName)) {
      $lUniqueName = $pUsername.$lCounter;
      $lCounter++;
    }
    return $lUniqueName;
  }
}
<?php
/**
 * memcache behavior
 *
 * @author Matthias Pfefferle
 */
class NoMemcacheBehavior extends Doctrine_Template {
  /**
   * use our memcache instead database when calling method
   *
   * @author Matthias Pfefferle
   * @param int $pPk
   * @return array of user objects
   */
  public function retrieveByPkTableProxy($pPk) {
    $lInvoker = $this->getInvoker();

    $lClassName = get_class($lInvoker);

    $lObject = null;
    $lMemcacheId = strtolower($lClassName) . "-" . $pPk;

    // first try GLOBALS cache
    if (isset($GLOBALS['CACHE'][strtoupper($lClassName)][$pPk])) {
      $lObject = $GLOBALS['CACHE'][strtoupper($lClassName)][$pPk];
    } else {
      $lObject = $lInvoker->getTable()->find($pPk);
    }

    if ($lObject) {
      $GLOBALS['CACHE'][strtoupper($lClassName)][$pPk] = $lObject;
      return $lObject;
    } else {
      return null;
    }
  }

  /**
   * use our memcache instead database when calling method
   *
   * @author Matthias Pfefferle
   * @param array $pPks
   * @return array of user objects
   */
  public function retrieveByPKsTableProxy($pPks) {
    $q = $lInvoker->getQuery()->where('id IN ?', $pPks);

    return $q->fetch();
  }
}
?>
<?php
/**
 * memcache behavior
 *
 * @author Matthias Pfefferle
 */
class MemcacheBehavior extends Doctrine_Template {
  /**
   * generates an objects memcache-id
   *
   * @author Matthias Pfefferle
   * @return string
   */
  public function getMemcacheId() {
    $lInvoker = $this->getInvoker();

    return strtolower(get_class($lInvoker)) . "-" . $lInvoker->getId();
  }

  public function setTableDefinition() {
    $this->addListener(new MemcacheListener());
  }
}
?>
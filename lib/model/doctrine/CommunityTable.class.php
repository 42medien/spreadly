<?php
/**
 * Enter description here...
 *
 * @author Matthias Pfefferle
 */
class CommunityTable extends Doctrine_Table {
  /**
   * return instance
   *
   * @return CommunityTable
   */
  public static function getInstance() {
    return Doctrine_Core::getTable('Community');
  }

  /**
   * find community by "slug"
   *
   * @author Matthias Pfefferle
   * @param string $pSlug
   * @return Community|null
   */
  public static function retrieveBySlug($pSlug) {
    return self::getInstance()->findBy("slug", $pSlug);
  }

  /**
   * find community by "community"
   *
   * @author Matthias Pfefferle
   * @param string $pCommunity
   * @return Community|null
   */
  public static function retrieveByCommunity($pCommunity) {
    return self::getInstance()->findBy("community", $pSlug);
  }
}
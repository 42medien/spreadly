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
    return self::getInstance()->findOneBy("slug", $pSlug);
  }

  /**
   * find community by "community"
   *
   * @author Matthias Pfefferle
   * @param string $pCommunity
   * @return Community|null
   */
  public static function retrieveByCommunity($pCommunity) {
    return self::getInstance()->findOneBy("community", $pCommunity);
  }

  /**
   * returns all communities with a specific domain
   *
   * @author Matthias Pfefferle
   * @param string $pDomain
   * @return array
   */
  public static function retrieveByDomain($pDomain = null) {
    $lQuery = Doctrine_Query::create()->
      from('Community c')->
      where('c.oi_url IS NOT NULL AND c.oi_url <> "" AND c.oi_url <> " " AND c.community IS NOT NULL')->
      andWhere('c.community <> "website"')->
      orderBy('c.community ASC');

    if ($pDomain) {
      $lQuery->andWhere('c.oi_url LIKE ?', array("%".$pDomain."%"));
    }

    $lCommunities = $lQuery->execute();

    $lWebsite = Doctrine_Query::create()->
      from('Community c')->
      where('c.community = ?', array("website"))->
      fetchOne();

    if ($lWebsite) {
      $lCommunities[] = $lWebsite;
    }

    return $lCommunities;
  }
}
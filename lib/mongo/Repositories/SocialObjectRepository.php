<?php
namespace Repositories;

use Doctrine\ODM\MongoDB\DocumentRepository,
    \MongoManager,
    \UrlUtils;

class SocialObjectRepository extends DocumentRepository
{
  /**
   * When an activity is performed on an social object, we need to update it's counters, alias and services
   *
   * @param YiidActivity
   * @author Matthias Pfefferle
   */
  public function fromYiidActivity($activity) {
    $user_id = $activity->getUId();

    $ois = $activity->getOiids();
    $cids = $activity->getCids();

    $shared_url = $activity->getUrl();
    $original_url = UrlUtils::shortUrlExpander($shared_url);
    $normalized_url = UrlUtils::skipTrailingSlash($original_url);
    $aliases = array_values(array_unique(array(md5($shared_url), md5($original_url), md5($normalized_url))));

    $result = $this->createQueryBuilder()
                   ->findAndUpdate()
                   ->field('url_hash')->equals(md5($normalized_url))
                   ->upsert(true)
                   ->field('uids')->addToSet($user_id)
                   ->field('oiids')->addToSet(array('$each' => $ois))
                   ->field('cids')->addToSet(array('$each' => $cids))
                   ->field('alias')->addToSet(array('$each' => $aliases))
                   ->field('url')->set($normalized_url)
                   ->field('url_hash')->set(md5($normalized_url))
                   ->field('l_cnt')->inc(1)
                   ->field('u')->set(time())
                   ->getQuery()->execute();

    if ($result) {
      return $result;
    } else {
      return $this->findOneBy(array("url_hash" => md5($normalized_url)));
    }
  }
}
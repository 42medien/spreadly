<?php
namespace Documents;

use \sfProjectConfiguration;

/**
 * @Document(collection="social_object", repositoryClass="Repositories\SocialObjectRepository")
 * @HasLifecycleCallbacks
 * @InheritanceType("COLLECTION_PER_CLASS")
 *
 * @author Matthias Pfefferle
 * @author Hannes Schippmann
 */
class SocialObject extends BaseDocument {
  /** @Id */
  protected $id;

  /** @String */
  protected $url;

  /** @String */
  protected $url_hash;

  /** @Collection */
  protected $alias;

  /** @Collection */
  protected $oiids;

  /** @Collection */
  protected $cids;

  /** @Collection */
  protected $uids;

  /** @Int */
  protected $type;

  /** @String */
  protected $title;

  /** @String */
  protected $stmt;

  /** @String */
  protected $ecode;

  /** @String */
  protected $thumb_url;

  /** @Int */
  protected $l_cnt;

  /** @Int */
  protected $c_cnt;

  /** @Int */
  protected $enriched;

  /** @Int */
  protected $u;

  /** @Int */
  protected $c;

  public function __toString() {
    return $this->getUrl();
  }

  /**
   * Save an SocialObejct to MongoDB
   *
   * (non-PHPdoc)
   * @author weyandch
   * @see lib/vendor/symfony/lib/plugins/sfDoctrinePlugin/lib/vendor/doctrine/Doctrine/Doctrine_Record::save()
   */
  public function save() {
    if (!$this->getId()) {
      $this->setUrlHash(md5($this->getUrl()));
      $this->setC(time());
      if (!$this->getAlias()) {
        $this->setAlias(array(md5($this->getUrl())));
      }
    }
    $this->setU(time());

    $dm = MongoManager::getDM();
    $dm->persist($this);
    $dm->flush;
  }

  /**
   * This method returns the minuts/hours/day since publishing of this social object
   *
   * @author Christian Schätzle
   */
  public function getPublishingTime() {
  	$lSocialObjectDate = $this->getC();

  	sfProjectConfiguration::getActive()->loadHelpers(array('Date'));
  	$lDate = distance_of_time_in_words($lSocialObjectDate);

  	return $lDate;
  }

  /*************************************************************
   ***
   ***  CUSTOM GETTER && SETTER
   ***
   ************************************************************/
  public function getRelatedOnlineIdentityIds() {
    return $this->getOiids();
  }

  public function setRelatedOnlineIdentityIds($pRelatedOnlineIdentityIds = array()) {
    $this->setOiids($pROiIds);
  }

  public function getRelatedSocialActivityIds() {
    return $this->getSaids();
  }

  public function setRelatedSocialActivityIds($pRelatedActivityIds = array()) {
    $this->setSaids($pOiId);
  }

  public function getDescription() {
    return $this->getStmt();
  }

  public function setDescription($pDescription) {
    $this->setStmt($pDescription);
  }

  public function getEmbedCode() {
    return $this->getEcode();
  }

  public function setEmbedCode($pCode) {
    $this->setEcode($pCode);
  }

  public function getThumbnailUrl() {
    return $this->getThumbUrl();
  }

  public function setThumbnailUrl($pUrl) {
    return $this->setThumbUrl($pUrl);
  }

  public function getLikeCount() {
    return $this->getLCnt();
  }

  public function setLikeCount($pCount) {
    return $this->setLCnt($pCount);
  }

  public function getDislikeCount() {
    return $this->getDCnt();
  }

  public function setDislikeCount($pCount) {
    return $this->setDCnt($pCount);
  }

  public function getCommentCount() {
    return $this->getCCnt();
  }

  public function setCommentCount($pCount) {
    return $this->setCCnt($pCount);
  }

  public function getUpdatedOn() {
    return $this->getU();
  }

  public function setUpdatedOn($pTimestamp) {
    $this->setU($pTimestamp);
  }

  public function getCreatedOn() {
    return $this->getC();
  }

  public function setCreatedOn($pTimestamp) {
    $this->setC($pTimestamp);
  }
}

<?php
namespace Documents;

use \sfException,
    \UrlUtils,
    \StringUtils,
    \sfContext,
    \OnlineIdentityTable,
    \UserTable,
    \DealTable,
    \sfConfig,
    \StatsFeeder,
    \PostApiFactory,
    \SocialObjectTable,
    \YiidActivityTable,
    \Doctrine,
    \MongoId,
    \MongoManager,
    \sfProjectConfiguration;

/**
 * @Document(collection="yiid_activity", repositoryClass="Repositories\YiidActivityRepository")
 * @HasLifecycleCallbacks
 * @InheritanceType("COLLECTION_PER_CLASS")
 *
 * @author Matthias Pfefferle
 * @author Hannes Schippmann
 */
class YiidActivity extends BaseDocument {
  /** @Id */
  protected $id;

  /** @String */
  protected $url;

  /** @String */
  protected $url_hash;

  /** @Int */
  protected $u_id;

  /** @Collection */
  protected $oiids;

  /** @Collection */
  protected $cids;

  /** @Collection */
  protected $tags;

  /**
   * @String
   */
  protected $so_id;

  /** @Int */
  protected $score;

  /** @String */
  protected $like;

  /** @Int */
  protected $d_id;

  /** @String */
  protected $c_code;

  /** @String */
  protected $title;

  /** @String */
  protected $descr;

  /** @String */
  protected $comment;

  /** @Int */
  protected $c;

  /** @String */
  protected $thumb;

  /** @String */
  protected $cb_referer;

  /** @String */
  protected $cb_service;

  /** @NotSaved */
  protected $clickback;

  /**
   * save this shit!
   */
  public function save() {
    $dm = MongoManager::getDM();
    $dm->persist($this);
    $dm->flush();
  }

  public function setTitle($title) {
    $title = StringUtils::cleanupString($title);
    $this->title = $title;
  }

  public function setDescr($desc) {
    $desc = StringUtils::cleanupString($desc);
    $this->descr = $desc;
  }

  public function setComment($comment) {
    $comment = StringUtils::cleanupString($comment);
    $this->comment = $comment;
  }

  public function getComment() {
    if($this->isDeal()) {
      $i18n = sfContext::getInstance()->getI18N();
      $lDealComment = $i18n->__('grabbed the sponsored deal "%title%" on %url% for recommending...', array('%title%' => $this->getDeal()->getSummary(), '%url%' => $this->getUrl()));

      return $lDealComment;
    } else {
      // TODO: default 'likes' ???
      return $this->comment;
    }
  }

  public function generateHashtag() {
    return $this->isDeal() ? '#deal' : '#like';
  }

  public function setSoId($soId) {
    $soId = new MongoId(urldecode($soId)."");
    $this->so_id = $soId;
  }

  public function setUrl($url)       {
    $url = UrlUtils::cleanupHostAndUri($url);
    $this->url = $url;
    $tomd5 = UrlUtils::skipTrailingSlash($url);
    $this->url_hash = md5($tomd5);
  }

  public function setOiids($oiids) {
    if (!is_array($oiids)) {
      $oiids = explode(',', urldecode($oiids));
    }

    $this->oiids = $oiids;
  }

  /**
   * @deprecated
   */
  public function setScore($score) {
    $this->score = $score;
  }

  public function getScore() {
    return $this->score;
  }

  public function setClickback($clickback) {
    if ($clickback) {
      $lClickback = explode('.', urldecode($clickback));
      if (count($lClickback) > 1) {
        $this->setCbService($lClickback[0]);
        $this->setCbReferer($lClickback[1]);
      }
    }
  }

  public function setTags($tags)      {
    if ($tags && !is_array($tags)) {
      $tags = $this->normalizeTags($tags);
    }

    if ($tags) {
      $this->tags = $tags;
    }
  }

  /**
   * pre-save hook
   *
   * @PrePersist
   *
   * @author Matthias Pfefferle
   * @author Hannes Schippmann
   * @param unknown_type $event
   */
  public function prePersist() {
    // @todo merge to mongo code
    $this->verifyAndSaveOnlineIdentities();

    // @todo remove in future versions
    $this->setVerb("like");
    $this->setScore(1);

    $this->upsertSocialObject();
    $this->setC(time());
    $this->doValidate();

    $this->updateDealInfo();
  }

  /**
   * post-save hook
   *
   * @PostPersist
   *
   * @param unknown_type $event
   */
  public function postPersist() {
    UserTable::updateLatestActivityForUser($this->getUId(), time());
    $this->postIt();
    StatsFeeder::feed($this);
  }

  /**
   * sends the like to the connected communities like twitter, facebook, ...
   */
  public function postIt() {
    if (sfConfig::get('app_settings_post_to_services')==1) {
      // send messages to all services
      foreach (PostApiFactory::fromOnlineIdentityIdArray($this->getOiids()) as $client) {
        $client->doPost($this);
      }
    }
  }

  /**
   * returns the tracking link
   *
   * @author Hannes Schippmann
   * @param OnlineIdentity $pOnlineIdentity
   * @return string
   */
  public function generateUrlWithClickbackParam($pOnlineIdentity) {
    $lQueryChar = parse_url($this->getUrl(), PHP_URL_QUERY) ? '&' : '?';
    return $this->getUrl().$lQueryChar.'spreadly='.$pOnlineIdentity->getCommunity()->getCommunity().'.'.$this->getId();
  }

  /**
   * verifys all online-identity-ids
   */
  private function verifyAndSaveOnlineIdentities() {
    $lVerifiedOIs = OnlineIdentityTable::retrieveVerified($this->getUId(), $this->getOiids());
    $lCheck = $lVerifiedOIs->toArray();

    if (!$lCheck || empty($lCheck)) {
      throw new sfException("no valid online identities available", 0);
    }

    $lOIIds = array();
    $lCIds = array();

    foreach ($lVerifiedOIs as $lOI) {
      $lOIIds[] = $lOI->getId();
      $lCIds[] = $lOI->getCommunityId();
    }

    $this->setOiids(array_unique($lOIIds));
    $this->setCids(array_unique($lCIds));
  }

  /**
   * updates the deal informations of the yiid activity
   */
  private function updateDealInfo() {
    $deal = DealTable::getActiveDealByHostAndTagsAndUserId($this->getUrl(), $this->getTags(), $this->getUId());
    $dm = MongoManager::getDM();
    // sets the deal-id if it's not empty
    if ($deal && $deal->isActive() && !$dm->getRepository('Documents\YiidActivity')->findOneBy(array("d_id" => $deal->getId(), "u_id" => $this->getUId()))) {
      if ($coupon = $deal->popCoupon()) {
        $this->setDId(intval($deal->getId()));
        $this->setCCode($coupon);
      }
    }
  }

  /**
   * checks if the social-object exists or creates a new, if not
   */
  private function upsertSocialObject() {
    $dm = MongoManager::getDM();
    $so = $dm->getRepository('Documents\SocialObject')->fromYiidActivity($this);

    $this->setSoId($so->getId());
  }

  /**
   * checks if user is allowed to like this entry
   */
  private function doValidate() {
    if (!$this->getUId() || !$this->getUrl()) {
      throw new sfException("UserId or Url not present", 0);
    }

    $activity = YiidActivityTable::retrieveActionOnObjectById($this->getSoId(), $this->getUId(), $this->getDeal());

    if ($activity) {
      throw new sfException("user has already liked this url", 0);
    }
  }

  /**
   * wrapper for checkeing on clickback
   * @return boolean
   */
  public function isClickback() {
    return $this->getCbReferer() ? true : false;
  }

  /**
   * wrapper for checkeing on deal-activity
   * @return boolean
   */
  public function isDealActivity() {
    return $this->getDId() ? true : false;
  }

  /**
   * overrides the delete methode
   *
   * @param Doctrine_Connection $con
   */
  public function delete(Doctrine_Connection $con = null) {
    $this->collection->remove(array("_id" => new MongoId($this->getId()) ));
  }

  /**
   * at the moment this method returns the name of the first community
   *
   * @author Christian Schätzle
   */
  public function getCommunityNames() {
    $lObjectOiIds = $this->getCids();
    $lNamesArray = array();

    return Doctrine::getTable('Community')->find($lObjectOiIds[0])->getName();
  }

  /**
   * This method returns the minuts/hours/day since publishing of this activity
   *
   * @author Christian Schätzle
   */
  public function getPublishingTime() {
    $lSocialObjectDate = $this->getC();

    sfProjectConfiguration::getActive()->loadHelpers(array('Date'));
    $lDate = distance_of_time_in_words($lSocialObjectDate);

    return $lDate;
  }

  /**
   * lazy loads the user connected to this activity
   *
   * @return User
   */
  public function getUser() {
    $lUser = UserTable::getInstance()->retrieveByPk($this->getUId());

    return $lUser;
  }

  /**
   * checks if it is a deal activity or not
   *
   * @return boolean
   */
  public function isDeal() {
    return $this->getDId() ? true : false;
  }

  /**
   * Returns the associated Deal
   *
   * @return Deal|null
   */
  public function getDeal() {
    if ($this->getDId()) {
      return DealTable::getInstance()->find($this->getDId());
    } else {
      return null;
    }
  }

  /**
   * normalize the tag-string
   *
   * @param string $tags
   * @return array
   */
  private function normalizeTags($pTags) {
    $lTags = urldecode($pTags);
    $lTags = explode(",", $lTags);

    if (is_array($lTags)) {
      $lTagArray = array();
      foreach ($lTags as $key => $value) {
        if ($value = trim($value)) {
          $lTagArray[$key] = $value;
        }
      }

      $lTagArray = array_unique($lTagArray);

      return $lTagArray;
    } else {
      return null;
    }
  }

  /**
   * Returns the associated SocialObject
   *
   * @return SocialObject|null
   */
  public function getSocialObject() {
    if ($this->getSoId()) {
      $dm = MongoManager::getDM();
      return $dm->getRepository('Documents\YiidActivity')->findOneBy(array("id" => $this->getSoId()));
    } else {
      return null;
    }
  }
}
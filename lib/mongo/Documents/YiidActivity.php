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
    \Doctrine,
    \MongoId,
    \MongoManager,
    \DomainSubscriptionsTable,
    \DomainProfileTable,
    \sfProjectConfiguration,
    \CouponWebhookClient,
    \Doctrine_Query,
    Queue\Queue;

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

  /** @ReferenceOne(targetDocument="Documents\SocialObject", cascade="all") */
  protected $social_object;

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

  /** @Int */
  protected $cb;

  /** @String */
  protected $i_url;

  /** @String */
  protected $i_host;

  /** @Int */
  protected $i_id;

  /** @NotSaved */
  protected $clickback;

  /** @NotSaved */
  protected $new_checksum;

  /** @NotSaved */
  protected $so_id;

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

  public function getUniqueId() {
    return "tag:spreadly.com,".date("Y", $this->getC()).":/activity/".$this->getId();
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
  
  public function getThumb() {
    if ($this->thumb) {
      if (UrlUtils::checkUrlAvailability($this->thumb)) {
        return $this->thumb;
      } else {
        $this->thumb = null;
        $this->save();
      }
    }
    
    return null;
  }

  /**
   * pre-save hook
   *
   * @PrePersist
   *
   * @author Matthias Pfefferle
   * @author Hannes Schippmann
   */
  public function prePersist() {
    // @todo merge to mongo code
    $this->verifyAndSaveOnlineIdentities();

    // @todo remove in future versions
    $this->setVerb("like");
    $this->setScore(1);

    $this->upsertSocialObject();
    if(!$this->getC()) {
      $this->setC(time());
    }

    $this->completeDealInfos();

    $this->doValidate();
  }

  private function createJob() {
    //if ($this->hasDomainSubscriber()) {
      $job = new PushJob($this->getId());
      Queue::getInstance()->put($job);
    //}
  }

  public function getDomainProfile() {
    $result = Doctrine_Query::create()
        ->from('DomainProfile dp')
        ->where('dp.url = ?', parse_url($this->getUrl(), PHP_URL_HOST))
        ->andWhere('dp.state = ?', DomainProfileTable::STATE_VERIFIED)
        ->fetchOne();

    return $result;
  }

  public function hasDomainSubscriber() {
    if ($dp = $this->getDomainProfile()) {
      if (DomainSubscriptionsTable::getInstance()->findOneBy("domain_profile_id", $dp->getId())) {
        return true;
      }
    }

    return false;
  }

  /**
   * post-save hook
   *
   * @PostPersist
   */
  public function postPersist() {
    UserTable::updateLatestActivityForUser($this->getUId(), time());
    $this->postIt();

    StatsFeeder::feed($this);

    $this->distributeTags();

    if ($deal = $this->getDeal()) {
      $deal->participate($this->getUser());
    }

    $this->createJob();
  }

  /**
   * adds the tags to the user and domain_profile
   * model
   */
  private function distributeTags() {
    if ($dp = $this->getDomainProfile()) {
      $dp->addTag($this->getTags());
      $dp->save();
    }

    $user = $this->getUser();
    $user->addTag($this->getTags());
    $user->save();
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
   *
   * @throws sfException
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
   * checks if the social-object exists or creates a new, if not
   */
  public function upsertSocialObject() {
    $dm = MongoManager::getDM();
    $so = $dm->getRepository('Documents\SocialObject')->fromYiidActivity($this, isset($this->skipUrlCheck)&&$this->skipUrlCheck);

    $this->setSocialObject($so);
  }

  /**
   * checks if user is allowed to like this entry
   *
   * @throws sfException
   */
  private function doValidate() {
    $dm = MongoManager::getDM();
    if (!$this->getUId() || !$this->getUrl()) {
      throw new sfException("UserId or Url not present", 0);
    }

    $criteria = array("social_object.id" => $this->getSocialObject()->getId(), "u_id" => intval($this->getUId()));

    if ($this->getDId()) {
      $criteria["d_id"] = intval($this->getDId());
    } else {
      $criteria["d_id"] = array('$exists' => false);
    }

    $activity = $dm->getRepository('Documents\YiidActivity')->findOneBy($criteria);

    if ($activity) {
      throw new sfException("user has already liked this url", 0);
    }
  }

  /**
   * wrapper for checkeing on clickback
   *
   * @return boolean
   */
  public function isClickback() {
    return $this->getCbReferer() ? true : false;
  }

  /**
   * wrapper for checkeing on deal-activity
   *
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
   * This method returns the minuts/hours/day since publishing of this activity
   *
   * @author Christian Schätzle
   * @return string
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
   * return the number of clickback likes
   *
   * @return int
   */
  public function countClickbackLikes() {
    $dm = MongoManager::getDM();
    $count = $dm->getRepository("Documents\YiidActivity")->findBy(array("cb_referer" => $this->getId()));

    return count($count);
  }

  public function completeDealInfos() {
    $deal = $this->getDeal();

    if (!$deal) {
      return false;
    }

    $this->fromArray($deal->toYiidActivityArray());

    if ($this->i_url) {
      $this->setIHost(parse_url($this->i_url, PHP_URL_HOST));
      if ($dp = DomainProfileTable::getInstance()->retrieveByUrl($this->i_url)) {
        $this->setIId($dp->getId());
      }
    }

    if ($deal->getCouponType() == DealTable::COUPON_TYPE_UNIQUE_CODE) {
      $this->setCCode($deal->getUniqueCode());
    }

    return true;
  }

  public function getAnalyticsActivity() {
    $dm = \MongoManager::getStatsDM();
    return $dm->getRepository("Documents\AnalyticsActivity")->findOneBy(array("ya_id" => $this->getId()));
  }
}
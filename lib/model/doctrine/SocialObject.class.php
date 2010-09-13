<?php

/**
 * SocialObject
 *
 * This class has been auto-generated by the Doctrine ORM Framework
 *
 * @package    yiid
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class SocialObject extends BaseSocialObject
{

  /**
   * Save an SocialObejct to MongoDB
   *
   * (non-PHPdoc)
   * @author weyandch
   * @see lib/vendor/symfony/lib/plugins/sfDoctrinePlugin/lib/vendor/doctrine/Doctrine/Doctrine_Record::save()
   */
  public function save(Doctrine_Connection $conn = null) {
    if (!$this->getId()) {
      $this->setUrlHash(md5($this->getUrl()));
      $this->setCreatedOn(time());
      if (!$this->getAlias()) {
        $this->setAlias(array(md5($this->getUrl())));
      }
    }
    $this->setUpdatedOn(time());
    $lObjectToSave = $this->toArray(false);
    $lObjectToSave = SocialObjectParser::saveToArray($lObjectToSave);
    $lObjectToSave = SocialObjectTable::saveObjectToMongoDb($lObjectToSave);
    $this->setId($lObjectToSave['_id']); // cast mongoID to string
    if ($lObjectToSave) {
      return $lObjectToSave;
    }
    return false;


  }


  /**
   * When an activity is performed on an social object, we need to update it's counters, alias and services
   *
   * @param int $pUserId
   * @param array $pVerifiedOnlineIdentitys
   * @param string $pUrl
   * @param int $pScore
   * @param array $pServices
   * @author weyandch
   */
  public function updateObjectOnLikeActivity($pUserId, $pVerifiedOnlineIdentitys, $pUrl, $pScore, $pServices) {
    if ($pScore == YiidActivityTable::ACTIVITY_VOTE_POSITIVE) {
      $lCounterField = 'l_cnt';
    }
    elseif ($pScore == YiidActivityTable::ACTIVITY_VOTE_NEGATIVE) {
      $lCounterField = 'd_cnt';
    }
    else {
      return false;
    }

    SocialObjectTable::updateObjectInMongoDb(array("_id" => new MongoId($this->getId())),
                                             array( '$inc' => array($lCounterField => 1 ),
                                                    '$addToSet' => array('uids'  => $pUserId,
                                                                         'oiids' => array('$each' => $pVerifiedOnlineIdentitys),
                                                                         'cids'  => array('$each' => $pServices),
                                                                         'alias' => array('$each' => array(md5($pUrl)))),
                                                    '$set' => array('u' => time())
                                             )
    );
  }


  /**
   * Update Services and OnlineIdentites of an socialobject
   *
   * @param array() $pVerifiedOnlineIdentitys
   * @param array() $pServices
   */
  public function updateObjectActingIdentities($pUserId, $pVerifiedOnlineIdentitys, $pServices) {
    SocialObjectTable::updateObjectInMongoDb(array("_id" => new MongoId($this->getId())),
    array( '$addToSet' => array('oiids' => array('$each' => $pVerifiedOnlineIdentitys),
                                'cids' => array('$each' => $pServices),
                                'uids' => $pUserId,
    )));
  }


  /**
   * update basic information on this social object
   *
   * @param $pTitle
   * @param $pDescription
   * @param $pImage
   * @return unknown_type
   */
  public function updateObjectMasterData($pTitle = null, $pDescription = null, $pImage = null) {
    $lUpdateArray = array();
    if ($pTitle) {
      $pTitle  = htmlspecialchars_decode(strip_tags($pTitle));
      if (mb_detect_encoding($pTitle) != 'UTF-8') {
        $pTitle = utf8_encode($pTitle);
      }
      $lUpdateArray['title'] = $pTitle;
    }
    if ($pDescription) {
      $pDescription  = htmlspecialchars_decode(strip_tags($pDescription));
      if (mb_detect_encoding($pDescription) != 'UTF-8') {
        $pDescription = utf8_encode($pDescription);
      }
      $lUpdateArray['desc'] = $pDescription;
    }
    if ($pImage) {
      $lUpdateArray['thumb_url'] = $pImage;
    }

    SocialObjectTable::updateObjectInMongoDb(array("_id" => new MongoId($this->getId())),
                                                array(
                                               '$set' => $lUpdateArray
                                                ));
  }


  /**
   * adds an alias URL-Hash to an already known SocialObject
   * @param string $pUrl
   */
  public function addAlias($pUrl) {
    SocialObjectTable::updateObjectInMongoDb(array("_id" => new MongoId($this->getId())),
    array(
                                                 '$addToSet' => array('alias' => array('$each' => array(md5($pUrl)))))
    );
  }

  /**
   * at the moment this method returns the name of the first community
   *
   * @author Christian Schätzle
   */
  public function getCommunityNames() {
    $lObjectOiIds = $this->getRelatedOnlineIdentityIds();
    $lNamesArray = array();

    /*
    foreach($lObjectOiIds as $lId) {
    	$lOi = Doctrine::getTable('OnlineIdentity')->find($lId);
      $lName = Doctrine::getTable('Community')->find($lOi->getCommunityId())->getName();
      array_push($lNamesArray, $lName);
    }

    return $lNamesArray;
    */

    $lOi = Doctrine::getTable('OnlineIdentity')->find($lObjectOiIds[0]);
    return Doctrine::getTable('Community')->find($lOi->getCommunityId())->getName();
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

  /*** wrappers for getter && setters */

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

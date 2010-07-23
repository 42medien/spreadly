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
    $lObjectToSave = SocialObjectTable::saveObjectToMongoDb($lObjectToSave);
    $this->setId($lObjectToSave['_id']);
    if ($lObjectToSave) {
      return $lObjectToSave;
    }
    return false;


  }

  /**
   *
   * @author weyandch
   * @param $pVerifiedOnlineIdentitys
   * @param $pScore
   * @return unknown_type
   */
  public function updateObjectOnLikeActivity($pVerifiedOnlineIdentitys, $pUrl, $pScore) {
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
                                               '$addToSet' => array('oiids' => array('$each' => $pVerifiedOnlineIdentitys)),
                                               '$addToSet' => array('alias' => array('$each' => array(md5($pUrl)))))
                                              );
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
      $lUpdateArray['title'] = $pTitle;
    }
    if ($pDescription) {
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

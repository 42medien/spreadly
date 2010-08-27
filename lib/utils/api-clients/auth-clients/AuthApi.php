<?php
/**
 * abstract AuthApi class
 *
 * @author Matthias Pfefferle
 */
abstract class AuthApi {

  /**
   * abstract attributes
   * MUST BE IMPLEMENTED IN THE CHILDS
   */
  protected $aCommunity      = null;
  protected $aRedirectPlatform  = null;
  protected $aRedirectWidget = null;

  protected $aCommunityId    = null;
  protected $aRedirectTo     = null;

  public function __construct() {
    $lCommunity = CommunityTable::retrieveByCommunity($this->aCommunity);
    $this->aCommunityId = $lCommunity->getId();
  }

  /**
   * get matching community-object
   *
   * @author Matthias Pfefferle
   * @return Community
   */
  public function getCommunity() {
    $lCommunity = CommunityTable::getInstance()->retrieveByPk($this->aCommunityId);

    return $lCommunity;
  }

  /*public function setRedirectTo() {
    sfContext::getInstance()->get;
  }*/
}
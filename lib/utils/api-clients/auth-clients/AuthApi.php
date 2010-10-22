<?php
require_once(dirname(__FILE__).'/../../../vendor/sqs.php');
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

  public function getCallbackUri() {
    $lFolders = sfConfig::get("app_".$this->aCommunity."_oauth_callback_uri");

    return sfConfig::get("app_settings_url").$lFolders;
  }

  /**
   * Push OnlineIdentityId to Amazon Quque for asynchronous process
   *
   * @param int $pOnlineIdentityId
   */
  public function importContacts($pOnlineIdentityId) {
    AmazonSQSUtils::pushToQuque("ImportContacts", $pOnlineIdentityId);
  }

  /**
   * generates a OAuthConsumer
   *
   * @author Matthias Pfefferle
   * @return OAuthConsumer
   */
  public function getConsumer() {
    $lConsumer = new OAuthConsumer(sfConfig::get("app_".$this->aCommunity."_oauth_token"), sfConfig::get("app_".$this->aCommunity."_oauth_secret"));

    return $lConsumer;
  }
}
<?php

/**
 * stream components.
 *
 * @package    yiid
 * @subpackage stream
 * @author     Christian Schätzle
 */
class streamComponents extends sfComponents
{
  public function executeSidebar_left() {
/*    $lServices = array();
    $lTokens = AuthTokenTable::getAllTokensForPublishingByUser($this->getUser()->getUserId());


    foreach ($lTokens as $lToken) {
      $lServices[] = CommunityTable::getInstance()->retrieveByPk($lToken->getCommunityId());
    }
    */

    $this->pServices = CommunityTable::getInstance()->retrieveCommunitysForSocialPublishing();


    $this->pFriends = UserTable::getHottestFriendsForUser($this->getUser()->getUserId(), 1, 10);
    // get friends alphabetically
    $this->pAllFriends = UserTable::getAlphabeticalFriendsForUser($this->getUser()->getUserId());
    $this->pFriendsCount = $this->getUser()->getUser()->countFriends();
  }

  public function executeSearch_field() {}

  public function executeSidebar_right() {
  	//$this->pObject = SocialObjectTable::retrieveByPK($lObjectId);
    //$this->pActivities = YiidActivityTable::retrieveByYiidActivityId($this->getUser()->getId(), $lObjectId, 'all', 6, 1);
  }

  public function executeContacts_infobox() {

  }
}
?>
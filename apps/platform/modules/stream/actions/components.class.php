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
    $lServices = array();
    $lTokens = AuthTokenTable::getAllTokensForPublishingByUser($this->getUser()->getUserId());

    foreach ($lTokens as $lToken) {
      $lServices[] = CommunityTable::getInstance()->retrieveByPk($lToken->getCommunityId());
    }
    $this->pServices = $lServices;


    $this->pFriends = UserTable::getHottestFriendsForUser($this->getUser()->getUserId(), 1, 10);
    // get friends alphabetically
    // $this->pFriends = UserTable::getAlphabeticalFriendsForUser($this->getUser()->getUserId(), 1, 10);

  }

  public function executeSearch_field() {}

  public function executeSidebar_right() {
  	// get first object
  	$lObjectId = $this->getUser()->getAttribute('social_object_id');
  	$this->pObject = SocialObjectTable::retrieveByPK($lObjectId);
    $this->pActivities = YiidActivityTable::retrieveByYiidActivityId($this->getUser()->getId(), $lObjectId, 'all');
  }

  public function executeContacts_infobox() {

  }
}
?>
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


    $this->pFriends = UserTable::getFriendsForUser($this->getUser()->getUserId());

  }

  public function executeSearch_field() {}

  public function executeSidebar_right() {}
}
?>
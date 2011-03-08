<?php
/**
 * api actions.
 *
 * @package    yiid
 * @subpackage api
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class apiActions extends sfActions {
  public function executeLoad_friends(sfWebRequest $request) {
    $this->getResponse()->setContentType('application/json');

    $lUserId = $this->getUser()->getUserId();
    $lSocialObjectId = $request->getParameter('so_id');

    $lReturn['success'] = false;

    if($lUserId && $lSocialObjectId) {
    	$lFriends = SocialObjectTable::getFriendIdsForSocialObject($lSocialObjectId, $lUserId);

    	if($lFriends) {
    		$lReturn['success'] = true;
    		$lReturn['html'] =  $this->getPartial('profile/social_object_friends', array('pFriends' => array_slice($lFriends, 0, 3)));
    	}

    }
    return $this->renderText(json_encode($lReturn));
  }
}

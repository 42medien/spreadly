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
    $this->getResponse()->setHttpHeader('Access-Control-Allow-Origin', sfConfig::get("app_settings_button_url"));

    $this->getResponse()->setContentType('text/html');
    $this->setLayout(false);
    $lUserId = $this->getUser()->getUserId();
    $lSocialObjectId = $request->getParameter('so_id');

    $lReturn['success'] = false;
		$lReturn['html'] = false;
		$this->pFriends = array();
    if($lUserId && $lSocialObjectId) {
    	$this->pFriends = array_slice(UserTable::getFriendIdsBySocialObjectId($lSocialObjectId, $lUserId), 0, 3);

    	/*if($lFriends) {
    		$lReturn['success'] = true;
    		$lReturn['html'] =  $this->getPartial('profile/social_object_friends', array('pFriends' => array_slice($lFriends, 0, 3)));
    	}*/

    }
   	return $lReturn['html'];
  }
}

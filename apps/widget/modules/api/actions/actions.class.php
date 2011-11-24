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
	  $this->getResponse()->setHttpHeader('Access-Control-Allow-Origin', '*');

    $this->getResponse()->setContentType('text/html');
    $this->setLayout(false);
    $lUserId = $request->getParameter('u_id');
    $lSocialObjectId = $request->getParameter('so_id');

    $lReturn['success'] = false;
		$lReturn['html'] = false;
		$this->pFriends = array();
    if($lUserId && $lSocialObjectId) {
    	$this->pFriends = array_slice(UserTable::getFriendIdsBySocialObjectId($lSocialObjectId, $lUserId), 0, 3);
    }

   	return $lReturn['html'];
  }
}

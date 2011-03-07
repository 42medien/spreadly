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

    if (!$lUserId) {
      return $this->renderText(json_encode(array('success' => false, 'html'  => "gnarf")));
    }

    $lSocialObjectId = $request->getParameter('so_id');
    $lLimit = $request->getParameter('limit');

    $lFriends = SocialObjectTable::getFriendIdsForSocialObject($lSocialObjectId, $lUserId);

    return $this->renderText(
      json_encode(
        array(
          'success' => true,
          'html'  => $this->getPartial('widget/social_object_friends', array('pFriends' => $lFriends, 'pLimit' => $lLimit))
        )
      )
    );
  }
}

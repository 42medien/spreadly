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
  /**
   * initialize variables and check authentication
   *
   * (non-PHPdoc)
   * @author Christian Weyand
   * @see cache/frontend/prod/config/sfAction#initialize()
   */
  public function initialize($context, $module, $action) {
    $parentRet = parent::initialize($context, $module, $action);
    $request = $context->getRequest();

    $this->status = 200;
    $this->success = true;
    $this->message = 'success';

    if (!$this->getUser()->isAuthenticated()) {
      CookieUtils::removeWidgetIdentityCookie();
      $this->status = 401;
      $this->success = false;
      $this->message = $this->getPartial('api/widget_result_message');
    }

    $this->lUrl = $request->getParameter('url');
    if (!$this->success && !$this->lUrl) {
      $this->status = 404;
      $this->success = false;
    }

    $this->lType = $request->getParameter('type');
    $this->lIdentitysOwnedByUser = UserIdentityConTable::getOnlineIdentityIdsForUser($this->getUser()->getUserId());
    $this->lIdentitysSent = explode(',',$request->getParameter('serv'));

    $this->lTitle = $request->getParameter('title');
    $this->lDescription = $request->getParameter('description');
    $this->lPhoto = $request->getParameter('photo');

    return $parentRet;
  }

  /**
   * execute likes
   *
   * @author Christian Weyand
   * @param $request
   * @return unknown_type
   */
  public function executeLike(sfWebRequest $request) {

    $this->setLayout(false);
    $this->setTemplate(false);
    $this->getResponse()->setContentType('application/json');
    if ($this->status == 200) {
      $this->success = YiidActivityTable::saveLikeActivitys($this->getUser()->getId(),
                                                           $this->lUrl,
                                                           $this->lIdentitysOwnedByUser,
                                                           $this->lIdentitysSent,
                                                           YiidActivityTable::ACTIVITY_VOTE_POSITIVE,
                                                           $this->lType,
                                                           $this->lTitle,
                                                           $this->lDescription,
                                                           $this->lPhoto);
    } elseif ($this->status == 401) {

        $lSessId = CookieUtils::getSessionId();
        setcookie("yiid_temp_hash", $lSessId, time()+300, '/', sfConfig::get('app_settings_host'));
        $this->success = YiidActivityTable::storeTemporary($lSessId,
                                                           $this->lUrl,
                                                           $this->lIdentitysOwnedByUser,
                                                           $this->lIdentitysSent,
                                                           YiidActivityTable::ACTIVITY_VOTE_POSITIVE,
                                                           $this->lType,
                                                           $this->lTitle,
                                                           $this->lDescription,
                                                           $this->lPhoto);
    }
    return  $this->sendJsonResponse();
  }

  /**
   * execute dislikes
   *
   * @author Christian Weyand
   * @param $request
   * @return unknown_type
   */
  public function executeDislike(sfWebRequest $request) {
    $this->setLayout(false);
    $this->setTemplate(false);
    $this->getResponse()->setContentType('application/json');
    if ($this->status == 200) {
      $this->success = YiidActivityTable::saveLikeActivitys($this->getUser()->getId(),
                                                           $this->lUrl,
                                                           $this->lIdentitysOwnedByUser,
                                                           $this->lIdentitysSent,
                                                           YiidActivityTable::ACTIVITY_VOTE_NEGATIVE,
                                                           $this->lType,
                                                           $this->lTitle,
                                                           $this->lDescription,
                                                           $this->lPhoto);
    } elseif ($this->status == 401) {
      $lSessId = CookieUtils::getSessionId();
      setcookie("yiid_temp_hash",$lSessId , time()+300, '/', sfConfig::get('app_settings_host'));
      $this->success = YiidActivityTable::storeTemporary($lSessId,
                                                         $this->lUrl,
                                                         $this->lIdentitysOwnedByUser,
                                                         $this->lIdentitysSent,
                                                         YiidActivityTable::ACTIVITY_VOTE_NEGATIVE,
                                                         $this->lType,
                                                         $this->lTitle,
                                                         $this->lDescription,
                                                         $this->lPhoto);
    }
    return $this->sendJsonResponse();
  }

  private function sendJsonResponse() {
    return $this->renderText(
    json_encode(
    array(
      'success' => $this->success,
      'status' => $this->status,
      'message' => $this->message
    )));
  }
}

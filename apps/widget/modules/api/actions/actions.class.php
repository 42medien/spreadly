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

    $this->html = false;
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

    $this->lIdentitysSent = explode(',',$request->getParameter('serv'));
    if (trim($request->getParameter('serv')) == '' || empty($this->lIdentitysSent)) {
      $this->status = 450;
      $this->success = false;
    }

    $this->lDeal = DealTable::getActiveDealByUrlAndUserId($this->lUrl, $this->getUser()->getUserId());

    $this->lType = $request->getParameter('type');
    $this->lLikeDis = $request->getParameter('likedis');
    $this->lIdentitysOwnedByUser = OnlineIdentityTable::retrieveIdsByUserId($this->getUser()->getUserId());

    $this->lTitle = $request->getParameter('title');
    $this->lDescription = $request->getParameter('description');
    $this->lPhoto = $request->getParameter('photo');
    $this->lClickback = $request->getParameter('clickback', null);

    return $parentRet;
  }

  /**
   * execute likes
   *
   * @author Christian Weyand
   * @param $request
   * @return unknown_type
   */
  public function executeSave_like(sfWebRequest $request) {
    $this->setLayout(false);
    $this->setTemplate(false);
    $this->getResponse()->setContentType('application/json');

    if ($this->lDeal) {
      // @todo validate agbs
      // @todo set "status != 200" if it is not set
    }

    if ($this->status == 200) {
      $lActivity = YiidActivityTable::saveLikeActivitys($this->getUser()->getId(),
                                                        $this->lUrl,
                                                        $this->lIdentitysOwnedByUser,
                                                        $this->lIdentitysSent,
                                                        $this->lLikeDis,
                                                        $this->lType,
                                                        $this->lTitle,
                                                        $this->lDescription,
                                                        $this->lPhoto,
                                                        $this->lClickback
                                                       );
      // write success-state
      if ($lActivity != false) {
        $this->success = true;
      } else {
        $this->success = false;
      }
    }

    return  $this->sendJsonResponse();
  }


  private function sendJsonResponse() {
    return $this->renderText(
    json_encode(
    array(
      'success' => $this->success,
      'status' => $this->status,
      'message' => $this->message,
      'html' => $this->html
    )));
  }
}

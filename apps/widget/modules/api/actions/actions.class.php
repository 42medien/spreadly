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
  public function preExecute() {
    $request = $this->getRequest();

    $this->statictype = false;
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
      $this->message = "NO_SERVICES_ERROR";
    }

    $this->lDeal = DealTable::getActiveDealByHostAndUserId($this->lUrl, $this->getUser()->getUserId());

    if ($this->lDeal && $this->success == true) {
      if($request->getParameter('coupon-accept-tod', null)){
      	$this->status = 200;
      	$this->success = true;
      } else {
      	$this->status = 700;
      	$this->message = 'ACCEPT_TERMS_OF_DEAL_ERROR';
      	$this->success = false;
      }
    }


    $this->lType = $request->getParameter('type');
    $this->lLikeDis = $request->getParameter('likedis');
    $this->lTitle = $request->getParameter('title');
    $this->lDescription = $request->getParameter('description');
    $this->lPhoto = $request->getParameter('photo');
    $this->lClickback = $request->getParameter('clickback', null);
    $this->lTags = $request->getParameter('tags', null);
  }

  /**
   * execute likes
   *
   * @author Christian Weyand
   * @param $request
   * @return unknown_type
   */
  public function executeSave_like(sfWebRequest $request) {
  	$this->html = false;
    $this->setLayout(false);
    $this->setTemplate(false);
    $this->getResponse()->setContentType('application/json');

    if ($this->status == 200) {
      $lActivity = YiidActivityTable::saveLikeActivitys($this->getUser()->getId(),
                                                        $this->lUrl,
                                                        //$this->lIdentitysOwnedByUser,
                                                        $this->lIdentitysSent,
                                                        $this->lLikeDis,
                                                        $this->lType,
                                                        $this->lTitle,
                                                        $this->lDescription,
                                                        $this->lPhoto,
                                                        $this->lClickback,
                                                        $this->lTags
                                                       );
      // write success-state
  		if ($lActivity) {
        // set deal partial
        if ($lActivity->isDeal()) {
          $this->html = $this->getPartial('static/deal_info', array('pYiidActivity' => $lActivity));
          $this->statictype = 'deal';
        }
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
      'html' => $this->html,
      'statictype' => $this->statictype
    )));
  }
}

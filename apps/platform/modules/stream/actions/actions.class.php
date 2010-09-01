<?php

/**
 * stream actions.
 *
 * @package    yiid
 * @subpackage stream
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class streamActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    $lObjectsCount = 30;
    $this->getResponse()->setSlot('js_document_ready', $this->getPartial('stream/js_init_stream.js'));
    $lObjects = $this->pSocialObjects = SocialObjectTable::retrieveHotObjets($this->getUser()->getUserId(), null, null, $lObjectsCount, 1, $lObjectsCount);
  }

  public function executeNew(sfWebRequest $request) {

    $lObjectsCount = 3;
    $lDoPaginate = true;

    $this->getResponse()->setContentType('application/json');
    $lCallback = $request->getParameter('callback', 'logerror');
    $lContactId = $request->getParameter('userid', null);
    $lComId = $request->getParameter('comid', null);
    $lPage = $request->getParameter('page', 1);
    $lCss = $request->getParameter('css');
    $lString = '';
    if($lContactId) {
      $lString = ', "userid":"'.$lContactId.'"';
    } elseif ($lComId) {
      $lString = ', "comid":"'.$lComId.'"';
    }

    $pActivities = YiidActivityTable::retrieveLatestActivitiesByContacts($this->getUser()->getUserId(),$lContactId, $lComId, $lObjectsCount, $lPage, $lObjectsCount);

    if(count($pActivities) < $lObjectsCount)
      $lDoPaginate = false;

    return $this->renderText(
      $lCallback.'('.
      json_encode(
        array(
          "stream"  => $this->getPartial('stream/new_stream', array('pActivities' => $pActivities)),
          "action" => "stream/new",
          "dataobj" => '{"callback":"'.$lCallback.'"'.$lString.'}',
          "page" => $lPage,
          "css" => $lCss,
          "pDoPaginate" => $lDoPaginate
        )
      )
      .");"
    );
  }

  public function executeHot(sfWebRequest $request) {

    $lObjectsCount = 3;
    $lDoPaginate = true;

    $this->getResponse()->setContentType('application/json');
    $lCallback = $request->getParameter('callback', 'logerror');
    $lContactId = $request->getParameter('userid', null);
    $lComId = $request->getParameter('comid', null);
    $lPage = $request->getParameter('page', 1);
    $lCss = $request->getParameter('css');
    $lString = '';
    if($lContactId) {
      $lString = ', "userid":"'.$lContactId.'"';
    } elseif ($lComId) {
      $lString = ', "comid":"'.$lComId.'"';
    }

    $pSocialObjects = SocialObjectTable::retrieveHotObjets($this->getUser()->getUserId(),$lContactId, $lComId, $lObjectsCount, $lPage, $lObjectsCount);

    if(count($pSocialObjects) < $lObjectsCount)
      $lDoPaginate = false;

    return $this->renderText(
      $lCallback.'('.
      json_encode(
        array(
          "stream"  => $this->getPartial('stream/whats_hot_stream', array('pSocialObjects' => $pSocialObjects)),
          "action" => "stream/hot",
          "dataobj" => '{"callback":"'.$lCallback.'"'.$lString.'}',
          "page" => $lPage,
          "css" => $lCss,
          "pDoPaginate" => $lDoPaginate
        )
      )
      .");"
    );
  }

  public function executeNot(sfWebRequest $request) {

    $lObjectsCount = 6;
    $lDoPaginate = true;

    $this->getResponse()->setContentType('application/json');
    $lCallback = $request->getParameter('callback', 'GlobalError.logerror');
    $lContactId = $request->getParameter('userid', null);
    $lComId = $request->getParameter('comid', null);
    $lPage = $request->getParameter('page', 1);
    $lCss = $request->getParameter('css');
    $lString = '';
    if($lContactId) {
      $lString = ', "userid":"'.$lContactId.'"';
    } elseif ($lComId) {
      $lString = ', "comid":"'.$lComId.'"';
    }

    $pSocialObjects = SocialObjectTable::retrieveFlopObjects($this->getUser()->getUserId(),$lContactId, $lComId, $lObjectsCount, $lPage, $lObjectsCount);

    if(count($pSocialObjects) < $lObjectsCount)
      $lDoPaginate = false;

    return $this->renderText(
      $lCallback.'('.
      json_encode(
        array(
          "stream"  => $this->getPartial('stream/whats_not_stream', array('pSocialObjects' => $pSocialObjects)),
          "action" => "stream/not",
          "dataobj" => '{"callback":"'.$lCallback.'"'.$lString.'}',
          "page" => $lPage,
          "css" => $lCss,
          "pDoPaginate" => $lDoPaginate
        )
      )
      .");"
    );
  }

  public function executeGet_item_detail(sfWebRequest $request) {
    $this->getResponse()->setContentType('application/json');
    $lCallback = $request->getParameter('callback', 'GlobalError.logerror');
    $lCss = $request->getParameter('css');
    $lItemId = $request->getParameter('itemid');
    $lSocialObject = SocialObjectTable::retrieveByPK($lItemId);
    $lActivities = YiidActivityTable::retrieveByYiidActivityId($this->getUser()->getId(), $lItemId, 'all');

    return $this->renderText(
      $lCallback.'('.
      json_encode(
        array(
          "itemdetail"  => $this->getPartial('stream/item_detail', array('pObject' => $lSocialObject, 'pActivities' => $lActivities)),
          "css" => $lCss
        )
      )
      .");"
    );
  }

  public function executeGet_item_detail_stream(sfWebRequest $request) {
    $this->getResponse()->setContentType('application/json');
    $lActivitiesCount = 6;
    $lDoPaginate = true;
    $lCallback = $request->getParameter('callback', 'GlobalError.logerror');
    $lCase = $request->getParameter('case', 'all');
    $lItemId = $request->getParameter('itemid');
    $lPage = $request->getParameter('page', 1);
    $lActivities = YiidActivityTable::retrieveByYiidActivityId($this->getUser()->getId(), $lItemId, $lCase, $lActivitiesCount, $lPage);
    $lCss = $request->getParameter('css');

    if(count($lActivities) < $lActivitiesCount)
      $lDoPaginate = false;

    return $this->renderText(
      $lCallback.'('.
      json_encode(
        array(
          "stream"  => $this->getPartial('stream/item_shares', array('pActivities' => $lActivities, 'pItemId' => $lItemId)),
          "dataobj" => '{"action":"stream/get_item_detail_stream", "callback":"'.$lCallback.'", "case":"'.$lCase.'", "itemid":"'.$lItemId.'"}',
          "page" => $lPage++,
          "css" => $lCss,
          "pDoPaginate" => $lDoPaginate
        )
      )
      .");"
    );
  }

  public function executeGet_contacts_by_sortname(sfWebRequest $request) {
    $this->getResponse()->setContentType('application/json');

    $lFriendsCount = 10;
    $lDoPaginate = true;

  	$lChar = $request->getParameter('sortname', '');
  	$lPage = $request->getParameter('page', 1);
    $lUsers = UserTable::getFriendsByName($this->getUser()->getUserId(), $lChar, $lPage);
    $lCounter = UserTable::countFriendsByName($this->getUser()->getUserId(), $lChar);

    return $this->renderText(
      json_encode(
        array(
          "html"  => $this->getPartial('stream/sidebar_friendlist', array('pFriends' => $lUsers->getData())),
          "pCounter" => $lCounter
        )
      )
    );
  }

  public function executeGet_friends(sfWebRequest $request) {
    $this->getResponse()->setContentType('application/json');

    $lFriendsCount = 10;
    $lDoPaginate = true;

    $lPage = $request->getParameter('page');
    $lUsers = UserTable::getAlphabeticalFriendsForUser($this->getUser()->getUserId(), $lPage, $lFriendsCount);

    if(count($lUsers) < $lFriendsCount)
      $lDoPaginate = false;

    return $this->renderText(
      json_encode(
        array(
          "html"  => $this->getPartial('stream/sidebar_all_friendlist', array('pFriends' => $lUsers->getData())),
          "pDoPaginate" => $lDoPaginate
        )
      )
    );
  }

  public function executeGet_active_friends(sfWebRequest $request) {
    $this->getResponse()->setContentType('application/json');

    $lFriendsCount = 10;
    $lDoPaginate = true;

    $lPage = $request->getParameter('page');
    $lUsers = UserTable::getHottestFriendsForUser($this->getUser()->getUserId(), $lPage, $lFriendsCount);

    if(count($lUsers) < $lFriendsCount)
      $lDoPaginate = false;

    return $this->renderText(
      json_encode(
        array(
          "html"  => $this->getPartial('stream/sidebar_active_friendlist', array('pFriends' => $lUsers->getData())),
          "pDoPaginate" => $lDoPaginate
        )
      )
    );
  }
}

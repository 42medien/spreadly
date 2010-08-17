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
    $this->getResponse()->setSlot('js_document_ready', $this->getPartial('stream/js_init_stream.js'));
    $this->pSocialObjects = SocialObjectTable::retrieveHotObjets($this->getUser()->getUserId());
  }

  public function executeNew(sfWebRequest $request) {
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


    $pActivities = YiidActivityTable::retrieveLatestActivitiesByContacts($this->getUser()->getUserId(),$lContactId, $lComId);

    return $this->renderText(
      $lCallback.'('.
      json_encode(
        array(
          "stream"  => $this->getPartial('stream/new_stream', array('pActivities' => $pActivities)),
          "action" => "stream/new",
          "dataobj" => '{"callback":"'.$lCallback.'"'.$lString.'}',
          "css" => $lCss
        )
      )
      .");"
    );
  }

  public function executeHot(sfWebRequest $request) {
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

    $pSocialObjects = SocialObjectTable::retrieveHotObjets($this->getUser()->getUserId(),$lContactId, $lComId);

    return $this->renderText(
      $lCallback.'('.
      json_encode(
        array(
          "stream"  => $this->getPartial('stream/whats_hot_stream', array('pSocialObjects' => $pSocialObjects)),
          "action" => "stream/hot",
          "dataobj" => '{"callback":"'.$lCallback.'"'.$lString.'}',
          "page" => $lPage,
          "css" => $lCss
        )
      )
      .");"
    );
  }

  public function executeNot(sfWebRequest $request) {
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

    $pSocialObjects = SocialObjectTable::retrieveFlopObjects($this->getUser()->getUserId(),$lContactId, $lComId);

    return $this->renderText(
      $lCallback.'('.
      json_encode(
        array(
          "stream"  => $this->getPartial('stream/whats_not_stream', array('pSocialObjects' => $pSocialObjects)),
          "action" => "stream/not",
          "dataobj" => '{"callback":"'.$lCallback.'"'.$lString.', "page": "'.$lPage.'"}',
          "page" => $lPage,
          "css" => $lCss
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
    $lCallback = $request->getParameter('callback', 'GlobalError.logerror');
    $lCase = $request->getParameter('case', 'all');
    $lItemId = $request->getParameter('itemid');
    $lActivities = YiidActivityTable::retrieveByYiidActivityId($this->getUser()->getId(), $lItemId, $lCase);
    $lPage = $request->getParameter('page', 0);
    $lCss = $request->getParameter('css');

    return $this->renderText(
      $lCallback.'('.
      json_encode(
        array(
          "stream"  => $this->getPartial('stream/item_shares', array('pActivities' => $lActivities, 'pItemId' => $lItemId)),
          "dataobj" => '{"action":"stream/get_item_detail_stream", "callback":"'.$lCallback.'", "case":"'.$lCase.'", "itemid":"'.$lItemId.'"}',
          "page" => $lPage++,
          "css" => $lCss
        )
      )
      .");"
    );
  }

  public function executeGet_contacts_by_sortname(sfWebRequest $request) {
    $this->getResponse()->setContentType('application/json');
  	$lChar = $request->getParameter('sortname', '');
    $lUsers = UserTable::getFriendsByName($this->getUser()->getUserId(), $lChar);
    return $this->renderText(
      json_encode(
        array(
          "html"  => $this->getPartial('stream/sidebar_friendlist', array('pFriends' => $lUsers->getData()))
        )
      )
    );
  }
}

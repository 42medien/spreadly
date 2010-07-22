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
    $this->pSocialObjects = SocialObjectTable::retrieveHotObjets();
  }

  public function executeNew(sfWebRequest $request) {
    $this->getResponse()->setContentType('application/json');
    $lCallback = $request->getParameter('callback', 'logerror');
    $lUserId = $request->getParameter('userid', null);
    $lComId = $request->getParameter('comid', null);
    $lCss = $request->getParameter('css');
    $lString = '';
    if($lUserId) {
      $lString = ', "userid":"'.$lUserId.'"';
    } elseif ($lComId) {
      $lString = ', "comid":"'.$lComId.'"';
    }

    return $this->renderText(
      $lCallback.'('.
      json_encode(
        array(
          "stream"  => $this->getPartial('stream/new_stream'),
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
    $lUserId = $request->getParameter('userid', null);
    $lComId = $request->getParameter('comid', null);
    $lPage = $request->getParameter('page', 0);    
    $lCss = $request->getParameter('css');
    $lString = '';
    if($lUserId) {
      $lString = ', "userid":"'.$lUserId.'"';
    } elseif ($lComId) {
      $lString = ', "comid":"'.$lComId.'"';
    }

    $pSocialObjects = SocialObjectTable::retrieveHotObjets();

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
    $lUserId = $request->getParameter('userid', null);
    $lComId = $request->getParameter('comid', null);
    $lPage = $request->getParameter('page', 0);
    $lCss = $request->getParameter('css');
    $lString = '';
    if($lUserId) {
      $lString = ', "userid":"'.$lUserId.'"';
    } elseif ($lComId) {
      $lString = ', "comid":"'.$lComId.'"';
    }

    $pSocialObjects = SocialObjectTable::retrieveFlopObjects();

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
    return $this->renderText(
      $lCallback.'('.
      json_encode(
        array(
          "itemdetail"  => $this->getPartial('stream/item_detail'),
          "css" => $lCss
        )
      )
      .");"
    );
  }

  public function executeGet_item_detail_stream(sfWebRequest $request) {
    $this->getResponse()->setContentType('application/json');
    $lCallback = $request->getParameter('callback', 'GlobalError.logerror');
    $lCase = $request->getParameter('case');
    $lItemId = $request->getParameter('itemid');
    $lPage = $request->getParameter('page', 0);
    $lCss = $request->getParameter('css');
    return $this->renderText(
      $lCallback.'('.
      json_encode(
        array(
          "stream"  => $this->getPartial('stream/item_shares'),
          "dataobj" => '{"action":"stream/get_item_detail_stream", "callback":"'.$lCallback.'", "case":"'.$lCase.'", "itemid":"'.$lItemId.'"}',
          "page" => $lPage++,
          "css" => $lCss
        )
      )
      .");"
    );

  }

}

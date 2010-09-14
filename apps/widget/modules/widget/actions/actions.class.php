<?php

/**
 * index actions.
 *
 * @package    yiid
 * @subpackage index
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class widgetActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    $this->redirect('http://www.yiid.it');
  }

 /**
  * Executes generatte action
  *
  * @param sfRequest $request A request object
  */
  public function executeGenerate(sfWebRequest $request)
  {
  	$this->redirect('@opendislike_stream');
  }

  public function executeGet_code(sfWebRequest $request) {
   $this->redirect('@opendislike_stream');
  }

  public function executeStream(sfWebRequest $request) {

  	$this->pDislikes = ActivityObjectPeer::getDislikeActivityObjects(10, 1);
  	$this->setLayout('layout_opendislike');
  }

  public function executeGet_dislikes(sfWebRequest $request){
  	$this->getResponse()->setContentType('application/json');
    $lPage = $this->getRequestParameter('page', 1);
    $lDislikes = ActivityObjectPeer::getDislikeActivityObjects(10, $lPage);
    return $this->renderText(
      json_encode(
        array(
          'success' => true,
          'stream'  => $this->getPartial('widget/stream_single_entry', array('pDislikes' => $lDislikes)),
          'pager'   => $this->getPartial('widget/dislike_pager', array('pPage' => $lPage))
        )
      )
    );
  }

    /**
   *
   * @author Christian Weyand
   * @author Karina Mies
   * @param $request
   * @return unknown_type
   */
  public function executeDislike_show(sfWebRequest $request) {
    $this->fontColor = $request->getParameter('f', '#000000');
    $this->bgColor = $request->getParameter('bg', '#ffffff');
    $this->dislikeCount = 0;
    $this->alreadyDisliked  = false;

    if (UrlUtils::isUrlValid($request->getParameter('url'))) {
      $this->url = $request->getParameter('url');
      $pUrlStat = UrlStatPeer::retrieveByUrl($this->url);

      if ($pUrlStat) {
        $this->dislikeCount = $pUrlStat->getDislikeCount();
      }
      if ($pUrlStat && $this->getUser()->isAuthenticated()) {
        $this->alreadyDisliked = ActivityUrlStatConPeer::checkUserParticipationOnUrl($this->getUser()->getUserId(), $pUrlStat->getId());
        // ActivityObjectPeer::checkAlreadyExists($this->getUser()->getUserId(), $this->urlIdentifier);
      }
    }
    $this->setLayout('layout_dislike');
  }


  /**
   *
   * @author Christian Weyand
   * @author Karina Mies
   * @param $request
   * @return unknown_type
   */
  public function executeDislike_save(sfWebRequest $request) {
    $this->getResponse()->setContentType('application/json');

    $this->url = $request->getParameter('url');

    if (!UrlUtils::isUrlValid($request->getParameter('url'))) {
      return sfView::NONE;
    }

    $pUrlStat = UrlStatPeer::retrieveByUrl($this->url);

    if (!$this->getUser()->isAuthenticated()) {

      return $this->renderText(
        json_encode(
        array(
              'state' => 'login',
              'url' => $this->url
              )));
      } else {
        if ($pUrlStat) {
          $pAlreadyDisliked = ActivityUrlStatConPeer::checkUserParticipationOnUrl($this->getUser()->getUserId(), $pUrlStat->getId());
        }
        if (!$pAlreadyDisliked) {
          // save Dislike for User
          $lDislike = ActivityObjectPeer::saveDislike($this->getUser()->getUser(), $this->url);
          return $this->renderText(
          json_encode(
          array(
                'state' => 'success'
          )));
        }

      }
    $this->setLayout(false);
    return sfView::NONE;
  }
  
  public function executeLoad_friends(sfWebRequest $request) {
    $this->getResponse()->setContentType('application/json');
    
  	$lSocialObjectId = $request->getParameter('so_id');
  	$lUserId = $request->getParameter('u_id');
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
  /*
  public function executeTest(sfWebRequest $request) {
  	$lSo = SocialObjectTable::getTestSo();
  	$lUser = UserTable::getInstance()->find(1);
  	
  	$this->lFriends = SocialObjectTable::getFriendIdsForSocialObject($lSo[0]->getId(), $lUser->getId());
 
  	$this->pLimit = 3;
  }
  */
}
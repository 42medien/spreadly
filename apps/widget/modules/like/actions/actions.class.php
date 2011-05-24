<?php

/**
 * like actions.
 *
 * @package    yiid
 * @subpackage like
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class likeActions extends sfActions {
  /**
   * Executes index action
   *
   * @param sfRequest $request A request object
   */
  public function executeIndex(sfWebRequest $request) {
    $dm = MongoManager::getDM();
    // check if already liked and redirect
    $lUrl = $request->getParameter("url", null);

    // ckeck url
    if ($lUrl) {
      // set redirect url
      $this->getUser()->setAttribute("redirect_after_login", $request->getUri(), "widget");

      $this->pIdentities = OnlineIdentityTable::getPublishingEnabledByUserId($this->getUser()->getUserId());
      // check active deals
      $this->pActiveDeal = DealTable::getActiveByHost($lUrl, $request->getParameter("tags", null));
      $this->pActivity = null;

      // if there is an active deal
      if($this->pActiveDeal) {
        $this->pActivity = $dm->getRepository("Documents\YiidActivity")->findOneBy(array("d_id" => intval($this->pActiveDeal->getId()), "u_id" => intval($this->getUser()->getId())));

        // check if user has already dealt
        if(!$this->pActivity) {
    			$this->getResponse()->setSlot('js_document_ready', $this->getPartial('like/js_init_deal.js'));
    			$this->pUrl = $request->getParameter('url');
    			$this->pTags = $request->getParameter('tags');
    			$this->pClickback = $request->getParameter('clickback');
          $this->setTemplate('deal');
          return sfView::SUCCESS;
        } else {
          $this->pActivity = $dm->getRepository("Documents\YiidActivity")->findOneBy(array("url" => $lUrl, "u_id" => intval($this->getUser()->getId()), "d_id" => array('$exists' => false)));

          // if user has already liked
          if($this->pActivity) {
            $this->redirect('@widget_deals');
          }
        }
      }

      $this->pActivity = $dm->getRepository("Documents\YiidActivity")->findOneBy(array("url" => $lUrl, "u_id" => intval($this->getUser()->getId()), "d_id" => array('$exists' => false)));

      if($this->pActivity) {
        $this->redirect('@widget_likes');
      }
    } elseif ($lUrl = $this->getUser()->getAttribute("redirect_after_login", null, "widget")) {
      $this->redirect($lUrl);
    } else {
      $this->forward("like", "nourl");
    }

    $lYiidMeta = new YiidMeta();
    $lYiidMeta->fromParams($request->getParameterHolder());
    $this->pYiidMeta = SocialObjectParser::fetch($request->getParameter("url"), $lYiidMeta);

    if ($this->pYiidMeta === false) {
      return $this->setTemplate("wrong_url");
    }

    $this->getResponse()->setSlot('js_document_ready', $this->getPartial('like/js_init_like.js', array('pImgCount' => count($this->pYiidMeta->getImages()), 'pUrl' => $request->getParameter("url"))));
  }

  public function executeSave(sfWebRequest $request) {
  	$this->getResponse()->setContentType('application/json');
  	$lParams = $request->getParameter('like');

		$lParams['u_id'] = $this->getUser()->getUserId();
		$lActiveDeal = DealTable::getActiveDealByHostAndTagsAndUserId($lParams['url'], $lParams['tags'], $lParams['u_id']);
		// Check if user accepted TOS if he is attempting to participate in deal
		if($lActiveDeal && $lParams['ignore_deal'] == 0) {
  		$lParams['d_id'] = $lActiveDeal->getId();
  		if($lParams['tos']!='on') {
  		  $lReturn['success'] = false;
  		  $lReturn['message'] = "Terms of Service not checked.";
  		  return $this->renderText(json_encode($lReturn));
  		}
		}

  	$lActivity = new Documents\YiidActivity();
    $lActivity->fromArray($lParams);

    // try to save activity
    try {
      $lActivity->save();
      $lSuccess = true;
      if($lActivity->isDeal()){
      	$lReturn['html'] = $this->getPartial('like/coupon_used', array('pActivity' => $lActivity));
      }

      $this->getUser()->setAttribute("redirect_after_login", null, "widget");
		} catch (Exception $e) { // send error on exception
		  $this->getLogger()->err($e->getMessage());
      $lSuccess = false;
		}

  	$lReturn['success'] = $lSuccess;
    return $this->renderText(json_encode($lReturn));
  }

  public function executeGet_images(sfWebRequest $request) {
  	$this->getResponse()->setContentType('application/json');
    $lUrl = $request->getParameter("url");
    $lImages = ImageParser::fetch($lUrl);
    $lReturn['count'] = count($lImages);
    $lReturn['html'] = $this->getPartial('like/meta_images_list', array('pImages' => $lImages));
    return $this->renderText(json_encode($lReturn));
  }

  public function executeNourl(sfWebRequest $request){
    $this->getResponse()->setSlot('js_document_ready', $this->getPartial('like/js_init_nourl.js'));
  	$this->pIdentities = OnlineIdentityTable::getPublishingEnabledByUserId($this->getUser()->getUserId());
  }

  public function executeGet_like_content(sfWebRequest $request) {
  	$this->getResponse()->setContentType('application/json');
    $lUrl = $request->getParameter("url", null);
    $lReturn = array();
    $dm = MongoManager::getDM();

    $lActivity = $dm->getRepository("Documents\YiidActivity")->findOneBy(array("url" => $lUrl, "u_id" => intval($this->getUser()->getId()), "d_id" => array('$exists' => false)));

		if($lActivity) {
	      $lReturn['success'] = false;
	      $lReturn['msg'] = _('Already liked');
		} else {
	    $lYiidMeta = new YiidMeta();
	    $this->pYiidMeta = SocialObjectParser::fetch($lUrl, $lYiidMeta);
	    if ($this->pYiidMeta === false) {
	      $lReturn['success'] = false;
	      $lReturn['msg'] = _('Wrong Url');
	    } else {
	      $lReturn['success'] = true;
	    	$lReturn['html'] = $this->getPartial('like/like_content', array('pYiidMeta' => $lYiidMeta));
	    	$lReturn['imgcount'] = count($this->pYiidMeta->getImages());
	    	$lReturn['url'] = $lUrl;
	    }
		}

    return $this->renderText(json_encode($lReturn));
  }
}
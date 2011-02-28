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
    // check if already liked and redirect
    $lUrl = $request->getParameter("url", null);

    if ($lUrl) {
      $this->getUser()->setAttribute("redirect_after_login", $request->getUri(), "widget");

      $this->pIdentities = OnlineIdentityTable::getPublishingEnabledByUserId($this->getUser()->getUserId());
      $this->pActiveDeal = DealTable::getActiveByHost($lUrl, $request->getParameter("tags", null));
      $this->pActivity = null;

      if($this->pActiveDeal) {
        $this->pActivity = YiidActivityTable::getByDealIdAndUserIdAndUrl($this->pActiveDeal->getId(), $this->getUser()->getId(), $lUrl);

        if(!$this->pActivity) {
    			$this->getResponse()->setSlot('js_document_ready', $this->getPartial('like/js_init_deal.js'));
    			$this->pUrl = $request->getParameter('url');
    			$this->pTags = $request->getParameter('tags');
    			$this->pClickback = $request->getParameter('clickback');
          return $this->setTemplate('deal');
        } else {
          $this->pActivity = YiidActivityTable::retrieveByUserIdAndUrl($this->getUser()->getId(), $lUrl);

          if($this->pActivity) {
            return $this->redirect('@widget_deals');
          }
        }
      }

      $this->pActivity = YiidActivityTable::retrieveByUserIdAndUrl($this->getUser()->getId(), $lUrl);

      if($this->pActivity) {
        $this->redirect('@widget_likes');
      }

    } elseif ($lUrl = $this->getUser()->getAttribute("redirect_after_login", null, "widget")) {
      $this->redirect($lUrl);
    }

    $lYiidMeta = new YiidMeta();
    $lYiidMeta->fromParams($request->getParameterHolder());
    $this->pYiidMeta = SocialObjectParser::fetch($request->getParameter("url"), $lYiidMeta);

    $this->getResponse()->setSlot('js_document_ready', $this->getPartial('like/js_init_like.js', array('pImgCount' => count($this->pYiidMeta->getImages()), 'pUrl' => $request->getParameter("url"))));
  }

  public function executeSave(sfWebRequest $request) {
  	$this->getResponse()->setContentType('application/json');
  	$lParams = $request->getParameter('like');

		$lParams['u_id'] = $this->getUser()->getUserId();
		$lActiveDeal = DealTable::getActiveByHost($lParams['url'], $lParams['tags']);
		if($lActiveDeal) {
  		$lParams['d_id'] = $lActiveDeal->getId();
		}

  	$lActivity = new YiidActivity();
    $lActivity->fromArray($lParams);



    // try to save activity
    try {
      $lActivity->save();
      $lSuccess = true;
      if($lActivity->isDeal()){
      	$lReturn['html'] = $this->getPartial('like/coupon_used', array('pActivity' => $lActivity));
      }


		} catch (Exception $e) { // send error on exception
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

  public function executeDeal() {
    $this->getResponse()->setSlot('js_document_ready', $this->getPartial('deals/js_init_deals.js'));
    //$this->forward('default', 'module');
    $this->pActiveFormerlyKnownAsYiidActivitiesOfActiveDealForUser = YiidActivityTable::retrieveActivitiesOfActiveDealsByUserId($this->getUser()->getId());

    $this->setLayout('layout');
  }
}
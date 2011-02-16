<?php

/**
 * like actions.
 *
 * @package    yiid
 * @subpackage like
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class likeActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request) {
    if ($request->getParameter("url", null)) {
      $this->getUser()->setAttribute("redirect_after_login", $request->getUri(), "widget");
    } elseif ($lUrl = $this->getUser()->getAttribute("redirect_after_login", null, "widget")) {
      $this->redirect($lUrl);
    }

		$this->setLayout('layout');
    $this->pIdentities = OnlineIdentityTable::getPublishingEnabledByUserId($this->getUser()->getUserId());

    $lYiidMeta = new YiidMeta();
    $lYiidMeta->fromParams($request->getParameterHolder());
    $this->pYiidMeta = SocialObjectParser::fetch($request->getParameter("url"), $lYiidMeta);

    $this->getResponse()->setSlot('js_document_ready', $this->getPartial('like/js_init_like.js', array('pImgCount' => count($this->pYiidMeta->getImages()), 'pUrl' => $request->getParameter("url"))));
  }

  public function executeSave(sfWebRequest $request) {
  	$this->getResponse()->setContentType('application/json');
  	$lParams = $request->getParameter('like');

		$lParams['u_id'] = $this->getUser()->getUserId();
    $lParams['tags'] = $request->getParameter("tags");

  	$lActivity = new YiidActivity();
    $lActivity->fromArray($lParams);

    // try to save activity
    try {
      $lActivity->save();

      $lSuccess = true;
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
}

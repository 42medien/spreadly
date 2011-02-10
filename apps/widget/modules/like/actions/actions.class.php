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
		$this->setLayout('layout');
    $this->pIdentities = OnlineIdentityTable::getPublishingEnabledByUserId($this->getUser()->getUserId());

    $lYiidMeta = new YiidMeta();
    $lYiidMeta->fromParams($request->getParameterHolder());
    $this->pYiidMeta = SocialObjectParser::fetch($request->getParameter("url"), $lYiidMeta);


    $this->getResponse()->setSlot('js_document_ready', $this->getPartial('like/js_init_like.js', array('pImgCount' => count($this->pYiidMeta->getImages()), 'pUrl' => $request->getParameter("url"))));
  }

  public function executeSave(sfWebRequest $request) {
  	$this->getResponse()->setContentType('application/json');

  	return true;
  }

  public function executeGet_images(sfWebRequest $request) {
  	$this->getResponse()->setContentType('application/json');
    $lUrl = $request->getParameter("url");
    $lImages = ImageParser::fetch($lUrl);
    $lReturn['html'] = $this->getPartial('like/meta_images_list', array('pImages' => $lImages));
    return $this->renderText(json_encode($lReturn));

  }
}

<?php

/**
 * index actions.
 *
 * @package    communipedia
 * @subpackage index
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 9301 2008-05-27 01:08:46Z dwhittle $
 */
class indexActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex($request) {
    $this->redirect("http://yiid.com");
    /*$this->shortUrl = null;
    $this->form = new ShortUrlForm();

    if ($request->isMethod('post')) {
      $this->form->bind($request->getParameter('shorturl'));
      if ($this->form->isValid()) {

        if ($lShortUrl = ShortUrlTable::getByUrl($this->form->getValue('url'))) {
          $this->shortUrl = $lShortUrl->getShortedUrl();
        } else {
          $lShortUrl = $this->form->save();
          $this->shortUrl = $lShortUrl->getShortedUrl();
        }
      }
    } elseif ($request->getParameter('url')) {
      $this->form->bind(array('url' => $request->getParameter('url')));
      if ($this->form->isValid()) {
        if ($lShortUrl = ShortUrlTable::getByUrl($this->form->getValue('url'))) {
          $this->shortUrl = $lShortUrl->getShortedUrl();
        } else {
          $lShortUrl = $this->form->save();
          $this->shortUrl = $lShortUrl->getShortedUrl();
        }
      }
    }

    $this->pShortUrls = ShortUrlTable::getLatestUrls(5, true);*/
  }


  /**
   * Take a given identifier and lookup the URL it represents
   *
   * @author weyandch
   * @param unknown_type $request
   */
  public function executeShorturl($request) {
    $lIdentifier = $request->getParameter('identifier');

    $lPk = ShortUrlTable::uncharize($lIdentifier);
    $lShortUrl = ShortUrlTable::getInstance()->find($lPk);

    $this->forward404Unless($lShortUrl);

    // also support json output
    if ($request->getParameter('format') == 'json') {
      $this->getResponse()->setContentType('application/json');
      return $this->renderText(ShortUrlTable::prepareApiResponse($lShortUrl->getUrl()));
    } else {
      // check if it is a yiid entry
      $this->redirect($lShortUrl->getUrl());
    }
  }

  // redirect the 404 to the frontend
  public function executeError404($request) {
    $this->redirect(sfConfig::get('app_settings_url').'/static/404');
  }
}

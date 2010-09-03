<?php

/**
 * static actions.
 *
 * @package    yiid
 * @subpackage static
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class staticActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $lPage = $request->getParameter('page');
    $lCategory = $request->getParameter('category');

    try {
      $lCms = CmsTable::getCmsByPageAndCategory($lPage, $lCategory);
      $this->pHeadline = $lCms->getHeadline();
      $this->pText = $lCms->getText();

    } catch (ModelException $e) {
      $this->forward404();
    }
  }
}

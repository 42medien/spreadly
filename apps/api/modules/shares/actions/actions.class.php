<?php

/**
 * shares actions.
 *
 * @package    yiid
 * @subpackage shares
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class sharesActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request) {
    $this->getResponse()->setContentType('application/json');
    $this->setLayout(false);
  }
  
  /**
   * Executes index action
   *
   * @param sfRequest $request A request object
   */
   public function executeCounter(sfWebRequest $request) {
     $this->getResponse()->setContentType('application/json');
     
     
     $url = $request->getParameter("url", null);
     
     if (!$url) {
       $this->getResponse()->setStatusCode(409);
       return sfView::ERROR;
     }
     
     $dm = MongoManager::getDM();
     $social_object = $dm->getRepository("Documents\SocialObject")->findOneByUrl($url);
     
     if ($social_object) {
       $this->getResponse()->setStatusCode(200);
       $this->response_array = array("success" => array("code" => 200, "message" => "URL shared"), "counter" => $social_object->getLikeCount());
     } else {
       $this->getResponse()->setStatusCode(204);
       $this->response_array = array("success" => array("code" => 204, "message" => "URL not yet shared"), "counter" => 0);
     }

     $this->setLayout(false);
   }
}

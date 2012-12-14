<?php

/**
 * advertisement actions.
 *
 * @package    yiid
 * @subpackage advertisement
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class advertisementActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request) {
		$this->search = $request->getParameter("search", null);
		$this->ads = MongoManager::getDm()->getRepository('Documents\Advertisement')->findAll();
  }
  
  /**
   * Executes edit action
   *
   * @param sfRequest $request A request object
   */
  public function executeEdit(sfWebRequest $request) {
		$id = null;
      
    if ($request->isMethod("POST")) {
      $ads_array = $request->getParameter("ad");
      
      $ad = MongoManager::getDm()->getRepository('Documents\Advertisement')->findOneBy(array("id" => $ads_array["id"]));
      
			if (!$ad) {
				$this->redirect("advertisement/index");
			}
      
      $ad->setDomains($ads_array["domains"]);
      $ad->setAdCode($ads_array["ad_code"]);
      $ad->setAdWidth(intval($ads_array["ad_width"]));
      $ad->setAdHeight(intval($ads_array["ad_height"]));
      $ad->save();
      
      $id = $ads_array["id"];
    }
    
    if (!$id) {
      $id = $request->getParameter("id");
    }

    $this->ad = MongoManager::getDm()->getRepository('Documents\Advertisement')->findOneBy(array("id" => $id));
  }
  
  /**
   * Executes create action
   *
   * @param sfRequest $request A request object
   */
  public function executeCreate(sfWebRequest $request) {
    if ($request->isMethod("POST")) {
      $ads_array = $request->getParameter("ad");
      
      $ad = new Documents\Advertisement();
      $ad->setDomains($ads_array["domains"]);
      $ad->setAdCode($ads_array["ad_code"]);
      $ad->setAdWidth(intval($ads_array["ad_width"]));
      $ad->setAdHeight(intval($ads_array["ad_height"]));
      $ad->save();
      
      $this->redirect("advertisement/index");
    }
  }
  
  /**
   * Executes delete action
   *
   * @param sfRequest $request A request object
   */
  public function executeDelete(sfWebRequest $request) {
    $id = $request->getParameter("id");
    
    if ($ad = MongoManager::getDm()->getRepository('Documents\Advertisement')->findOneBy(array("id" => $id))) {
      $ad->delete();
    }

    $this->redirect("advertisement/index");
  }
}
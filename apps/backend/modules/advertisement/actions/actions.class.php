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
   * Executes index action
   *
   * @param sfRequest $request A request object
   */
  public function executeEdit(sfWebRequest $request) {
		$id = $request->getParameter("id");

    $this->ad = MongoManager::getDm()->getRepository('Documents\Advertisement')->findOneBy(array("id" => $id));
  }
}

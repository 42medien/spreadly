<?php

/**
 * spreads actions.
 *
 * @package    yiid
 * @subpackage spreads
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class spreadsActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request) {
    $yiid_activity = MongoManager::getDM()->getRepository('Documents\YiidActivity');

    $this->activities = $yiid_activity->findBy(array("u_id" => intval($this->getUser()->getUserId())))->limit(20)->sort(array("c" => "DESC"));
  }
}

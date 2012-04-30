<?php

/**
 * spreads actions.
 *
 * @package    yiid
 * @subpackage spreads
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
    $yiid_activity = MongoManager::getDM()->getRepository('Documents\YiidActivity');

    $activities = $yiid_activity->findBy(array("u_id" => intval($this->getUser()->getUserId())))->limit(10)->sort(array("c" => "DESC"));
    $max_activities = $yiid_activity->findBy(array("u_id" => intval($this->getUser()->getUserId())))->count();

    $pager = new ArrayPager();
    $pager->setMax($max_activities);
    $pager->setResultArray($activities);
    $pager->setPage($request->getParameter("page", 1));
    $pager->init();

    $this->activities = $pager;
  }
}

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

    $params = $request->getParameterHolder()->getAll();

    $activities = $yiid_activity->findByQuery($request);
    $max_activities = $yiid_activity->countByQuery($request);

    $pager = new ArrayPager();
    $pager->setMax($max_activities);
    $pager->setResultArray($activities);
    $pager->setPage($request->getParameter("p", 1));
    $pager->init();

    $this->activities = $pager;
  }
}

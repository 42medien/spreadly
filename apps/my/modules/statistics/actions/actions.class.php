<?php

/**
 * statistics actions.
 *
 * @package    yiid
 * @subpackage statistics
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class statisticsActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request) {
    $analytics_activity = MongoManager::getStatsDM()->getRepository('Documents\AnalyticsActivity');

    $this->activities = $analytics_activity->findBy(array("user_id" => intval($this->getUser()->getUserId())))->limit(20)->sort(array("cb" => "DESC"));

    $this->shares_complete = $analytics_activity->findBy(array("user_id" => intval($this->getUser()->getUserId())))->count();
    $this->clickbacks_complete = $analytics_activity->getOverallClickbacks($this->getUser()->getUserId());
    $this->tags = "";
  }
}

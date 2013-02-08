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
    $params['u_id'] = $this->getUser()->getUserId();

    $activities = $yiid_activity->findByQuery($params);
    $max_activities = $yiid_activity->countByQuery($params);

    $pager = new ArrayPager();
    $pager->setMax($max_activities);
    $pager->setResultArray($activities);
    $pager->setPage($request->getParameter("p", 1));
    $pager->init();

    $this->activities = $pager;
  }
  
  public function executeGlobal(sfWebRequest $request) {
    $yiid_activity = MongoManager::getDM()->getRepository('Documents\YiidActivity');
    
    $params = $request->getParameterHolder()->getAll();

    $activities = $yiid_activity->findByQuery($params);
    $max_activities = $yiid_activity->countByQuery($params);

    $pager = new ArrayPager();
    $pager->setMax($max_activities);
    $pager->setResultArray($activities);
    $pager->setPage($request->getParameter("p", 1));
    $pager->init();

    $this->activities = $pager;
  }
  
  public function executeSingle(sfWebRequest $request) {
  
  }
  
  /**
   * Executes index action
   *
   * @param sfRequest $request A request object
   */
   public function executeHost(sfWebRequest $request) {
     $social_object = MongoManager::getDM()->getRepository('Documents\SocialObject');
     
     $this->forward404Unless($request->getParameter("id"));
     $so = $social_object->find(new MongoId($request->getParameter("id")));
     $this->forward404Unless($so);
     $this->social_object = $so;
     
     $this->social_objects = $social_object->findBy(array("url" => array('$regex' => parse_url($so->getUrl(), PHP_URL_HOST))))->limit(10)->sort(array("u" => -1));
     
     $this->first_share = MongoManager::getStatsDM()->getRepository('Documents\AnalyticsActivity')->findBy(array("host" => parse_url($so->getUrl(), PHP_URL_HOST)))->sort(array("date" => 1))->limit(1)->getNext();
     $this->last_share = MongoManager::getStatsDM()->getRepository('Documents\AnalyticsActivity')->findBy(array("host" => parse_url($so->getUrl(), PHP_URL_HOST)))->sort(array("date" => -1))->limit(1)->getNext();

     $us = MongoManager::getStatsDM()->getRepository('Documents\UrlSummary');
     $this->url_summarys = $us->findBy(array("host" => parse_url($so->getUrl(), PHP_URL_HOST)))->limit(10)->sort(array("mp" => -1));
     
     $hs = MongoManager::getStatsDM()->getRepository('Documents\HostSummary');
     $this->host_summary = $hs->findOneBy(array("host" => parse_url($so->getUrl(), PHP_URL_HOST)));
   }
}

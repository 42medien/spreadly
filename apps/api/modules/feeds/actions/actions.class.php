<?php

/**
 * feeds actions.
 *
 * @package    yiid
 * @subpackage feeds
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class feedsActions extends sfActions {
  public function executeIndex() {
    $this->getResponse()->setHttpHeader("Content-Type", 'text/xml');
    $this->setLayout(false);
  }

  public function executeGlobal() {
    $lDm = MongoManager::getDM();
    $this->activities = $lDm->getRepository("Documents\YiidActivity")->findAll()->sort(array("c" => -1))->limit(100);

    $this->setLayout("atom_layout");
  }

  public function executeUser($request) {
    $id = $request->getParameter("id");

    $user = sfGuardUserTable::getInstance()->retrieveByUsernameOrEmailAddress($id);

    $this->forward404Unless($user);

    $hosts = array();
    foreach ($user->getDomainProfiles() as $domain_profile) {
      $hosts[] = $domain_profile->getUrl();
    }

    $lDm = MongoManager::getStatsDM();
    $this->activities = $lDm->createQueryBuilder("Documents\AnalyticsActivity")->field("host")->in($hosts)->sort(array("date" => -1))->limit(10)->getQuery()->execute();

    $this->user = $user;
    $this->setLayout("atom_layout");
  }
}
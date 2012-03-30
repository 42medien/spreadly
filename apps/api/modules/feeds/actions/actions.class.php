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
  public function executeGlobal() {
    $lDm = MongoManager::getDM();
    $this->activities = $lDm->createQueryBuilder("Documents\YiidActivity")->find()->sort(array("c" => -1))->limit(100)->getQuery()->execute();

    $this->setLayout("atom_layout");
  }

  public function executeUser($request) {
    $id = $request->getParameter("id");

    UserTable::retrieveByUsername();

    $lDm = MongoManager::getDM();
    $this->activities = $lDm->createQueryBuilder("Documents\YiidActivity")->find()->sort(array("c" => -1))->limit(100)->getQuery()->execute();

    $this->setLayout("atom_layout");
  }
}
<?php

/**
 * error_log actions.
 *
 * @package    yiid
 * @subpackage error_log
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class error_logActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request) {
    $lDm = MongoManager::getDM();
    $this->pErrors = $lDm->createQueryBuilder("Documents\ApiErrorLog")->find()->sort(array("c" => -1))->limit(30)->getQuery()->execute();
  }
}
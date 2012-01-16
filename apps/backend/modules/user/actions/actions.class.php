<?php

require_once dirname(__FILE__).'/../lib/userGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/userGeneratorHelper.class.php';

/**
 * user actions.
 *
 * @package    yiid
 * @subpackage user
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class userActions extends autoUserActions {

  public function executeListExportCsv(sfWebRequest $request) {
    $this->pUsers = UserTable::getInstance()->findAll();

    $this->setLayout('csv');
    $this->getResponse()->clearHttpHeaders();
    $this->getResponse()->setHttpHeader("Content-Type", 'text/plain');
    $this->getResponse()->setHttpHeader('Content-Disposition', 'attachment; filename=Users-'.date("Y-m-d").'.csv;');
  }
}

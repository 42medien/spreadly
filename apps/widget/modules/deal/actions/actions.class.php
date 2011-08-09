<?php

/**
 * deal actions.
 *
 * @package    yiid
 * @subpackage deal
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class dealActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request) {
    $deal = DealTable::getInstance()->getNextFromPool($this->getUser()->getUser());

    $this->deal = $deal;
  }
}

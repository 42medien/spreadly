<?php

/**
 * deals actions.
 *
 * @package    yiid
 * @subpackage deals
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class dealsActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    //$this->forward('default', 'module');
    $lActiveFormerlyKnownAsYiidActivitiesOfActiveDealForUser = YiidActivityTable::retrieveActivitiesOfActiveDealsByUserId($this->getUser()->getId());

    $this->setLayout('layout');
  }
}

<?php

/**
 * likes actions.
 *
 * @package    yiid
 * @subpackage likes
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class likesActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request) {
    $lUserId = $this->getUser()->getUserId();

    $this->pActivities = YiidActivityTable::retrieveLatestByUserId($lUserId);
  }
}
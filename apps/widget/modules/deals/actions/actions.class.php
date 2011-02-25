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
    $this->getResponse()->setSlot('js_document_ready', $this->getPartial('deals/js_init_deals.js'));
    //$this->forward('default', 'module');
    $this->pActiveFormerlyKnownAsYiidActivitiesOfActiveDealForUser = YiidActivityTable::retrieveDealActivitiesByUserId($this->getUser()->getId());

    $this->setLayout('layout');
  }

  public function executeExample(sfWebRequest $request)
  {
    $this->getResponse()->setSlot('js_document_ready', $this->getPartial('deals/js_init_deals.js'));
    //$this->forward('default', 'module');
    $this->pActiveFormerlyKnownAsYiidActivitiesOfActiveDealForUser = YiidActivityTable::retrieveDealActivitiesByUserId($this->getUser()->getId());

    $this->setLayout('layout');
  }

  public function executeGet_coupon_used(sfWebRequest $request) {
  	$this->getResponse()->setContentType('application/json');
		$lActivityId = $request->getParameter('activityid');
		$lReturn['html'] = $this->getComponent('deals', 'coupon_used', array('pActivityId' => $lActivityId));
    return $this->renderText(json_encode($lReturn));
  }
}

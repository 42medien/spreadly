<?php

require_once dirname(__FILE__).'/../lib/dealGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/dealGeneratorHelper.class.php';

/**
 * deal actions.
 *
 * @package    yiid
 * @subpackage deal
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class dealActions extends autoDealActions
{
  public function executeTransition_for(sfWebRequest $request) {
  	$this->getResponse()->setContentType('application/json');
  	$lParams = $request->getGetParameters();
  	$lDeal = DealTable::getInstance()->find($lParams['deal_id']);
  	$lError = "";
  	if($lDeal->canTransitionFor($lParams['event'])) {
    	$lDeal->transitionFor($lParams['event']);  	  
  	} else {
  	  $lError = "Cannot transition for: ".$lParams['event'];
  	}
  	return $this->redirect('deal/index');
  }

}

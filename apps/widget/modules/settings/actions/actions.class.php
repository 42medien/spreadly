<?php

/**
 * settings actions.
 *
 * @package    yiid
 * @subpackage settings
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class settingsActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    //$this->forward('default', 'module');
  }

  public function executeDelete_oi(sfWebRequest $request){
  	$this->getResponse()->setContentType('application/json');
    $lUser = $this->getUser()->getUser();
    $lOis = $lUser->getOnlineIdentitesAsArray();
  	$lId = $request->getParameter("id");
  	$lDeleted = false;

  	$lOi = OnlineIdentityTable::getInstance()->find($lId);
		$lReturn['html'] =  $this->getComponent('like','share_section', array('pError' => _("Sorry, it's not possible to delete this profile")));

  	if(in_array($lId, $lOis)){
  		try {

				$lOi->delete();
				$lDeleted = true;
				 $lReturn['html'] =  $this->getComponent('like','share_section');

  		} catch (Exception $e) {
  			$lDeleted = false;
  		}
  	}

    $lReturn['success'] = $lDeleted;

    return $this->renderText(json_encode($lReturn));
  }
}

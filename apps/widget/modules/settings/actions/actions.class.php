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
  	$this->getResponse()->setContentType('application/json');
  	$lUser = $this->getUser()->getUser();
  	$lReturn['html'] =  $this->getComponent('settings','edit_settings', array('pUser' => $lUser));

		return $this->renderText(json_encode($lReturn));
  }

  public function executeSelect_image(sfWebRequest $request){
  	$this->getResponse()->setContentType('application/json');
		$lOiId = $request->getParameter("oid");
  	$lUser = $this->getUser()->getUser();
  	$lOi = OnlineIdentityTable::getInstance()->find($lOiId);

		if($lOi->getUserId() == $lUser->getId()){
			$lOi->setUseAsAvatar(true);
			$lOi->save();
		}

		return $this->renderText(json_encode($lReturn));

  }

  public function executeDelete_oi(sfWebRequest $request){
  	$this->getResponse()->setContentType('application/json');
    $lUser = $this->getUser()->getUser();
    //$lOis = $lUser->getOnlineIdentitesAsArray();
  	$lOiId = $request->getParameter("id");
  	$lDeleted = false;
  	$lOi = OnlineIdentityTable::getInstance()->find($lOiId);

		$lReturn['html'] =  $this->getComponent('like','share_section', array('pError' => _("Sorry, it's not possible to delete this profile")));

  	if($lOi->getUserId() == $lUser->getId()){
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

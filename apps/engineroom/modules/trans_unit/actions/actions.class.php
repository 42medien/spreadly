<?php

require_once dirname(__FILE__).'/../lib/trans_unitGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/trans_unitGeneratorHelper.class.php';

/**
 * trans_unit actions.
 *
 * @package    yiid
 * @subpackage trans_unit
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class trans_unitActions extends autoTrans_unitActions
{

  public function executeNew(sfWebRequest $request)
  {
    $this->form = $this->configuration->getForm();
   // var_dump($this->form);
    $this->trans_unit = $this->form->getObject();
  }



 public function executeCreate_wildcard(sfWebRequest $request) {
    if($request->getParameter('create') == 1) {
      $this->lWildcardName = $request->getParameter('wildcard_name');
      $this->lCreateAfterEmptySearch = true;
    } else {
      $this->lWildcardName = '';
      $this->lCreateAfterEmptySearch = false;
    }

    if($request->getMethod() == 'POST') {
      $lWildcardSource = $request->getParameter('wildcard_name');
      $lToTranslateParams = $request->getParameter('to_translate');
      if($lWildcardSource == '') {
        $this->getUser()->setFlash('error', 'Please insert a wildcard name!');
        $this->redirect('trans_unit/create_wildcard');
      }

      // create wildcard
      TransUnitTable::createWildcard($lWildcardSource, 'messages');

      // create translations
      $lTransUnitData = $request->getParameter('wildcard');
      foreach(LanguageTable::getAllLanguages(false) as $lCulture) {
      $lTransUnit = TransUnitTable::retrieveWildcardObject($lCulture, 'messages', $lWildcardSource);


        $lTransUnit->setTarget($lTransUnitData["$lCulture"]['target']);
        //$lTransUnit->setComments($lTransUnitData['comment']);
        $lTransUnit->setAuthor('hugo'); //$this->getUser()->getUser()->getFullname());
        if((isset($lToTranslateParams["$lCulture"]) && $lToTranslateParams["$lCulture"] == 'on') || $lTransUnitData["$lCulture"]['target'] == '') {
          $lTransUnit->setTranslated(false);
        } else {
          $lTransUnit->setTranslated(true);
        }
        $lTransUnit->save();
      }

      $this->getUser()->setFlash('wildcard_edited', $lTransUnit->getId());
//die();
      $this->redirect('trans_unit/new');
    }
  }
  
  public function executeSave_translation(sfWebRequest $request) {
    $lWildcards = $request->getParameter('wildcard');
    $lToTranslateParams = $request->getParameter('to_translate');
    $lReferer = $request->getParameter('referer');

    foreach($lWildcards as $lKey => $lValue) {
      $lWildcardId = $lKey;
      $lWildcardTarget = $lValue['target'];
      //$lWildcardComments = $lWildcard['comment'];
      $lWildcardObject = Doctrine::getTable('TransUnit')->find($lWildcardId);
      $lWildcardObject->setTarget($lWildcardTarget);

      $lCulture = $lWildcardObject->getCatalogue()->getTargetLang();
      if((isset($lToTranslateParams[$lCulture]) && $lToTranslateParams[$lCulture] == 'on') || $lWildcardTarget == '') {
        $lWildcardObject->setTranslated(false);
      } else {
        $lWildcardObject->setTranslated(true);
      }
      //$lWildcardObject->setComments($lWildcardComments);
      $lWildcardObject->setAuthor('hugo');//$lWildcardObject->setAuthor($this->getUser()->getUser()->getFullname());
      $lWildcardObject->save();
    }

    $this->getUser()->setFlash('wildcard_edited', $lWildcardObject->getId());

    //$this->redirect($lReferer);
    $this->redirect('trans_unit/new');
  }


  public function executeLook_for_wildcard(sfWebRequest $request)
  {
    $lWildcardString = $request->getParameter('wildcard');

    if(!$lWildcardString) $this->redirect('trans_unit/new');

    $this->lWildcardObjects = TransUnitTable::searchWildcard($lWildcardString, false, false);

    if (count($this->lWildcardObjects) == 0) {
      $this->lWildcardObjects  = array();
    }


    if(!$this->lWildcardObjects) {
      $this->redirect('trans_unit/create_wildcard?create=1&wildcard_name='.$lWildcardString);
    }

    $this->lSearchTag = $lWildcardString;
    $this->lReferer = sfConfig::get('app_settings_url').'/engineroom.php/trans_unit/new';
    $this->setTemplate('translate_wildcard');
/*    $this->form = $this->configuration->getForm();
    $this->trans_unit = $this->form->getObject();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
    */
  }
}

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

  public function executeCreate(sfWebRequest $request)
  {
    $this->form = $this->configuration->getForm();
    $this->trans_unit = $this->form->getObject();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }


}

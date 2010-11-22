<?php

/**
 * Login form for navigation header.
 * 
 * @package    yiid_stats
 * @subpackage form
 * @author     Hannes Schippmann
 * @version    SVN: $Id$
 */
class NavigationLoginForm extends BaseForm
{
  /**
   * @see sfForm
   */
  public function setup()
  {
    $this->setWidgets(array(
      'username' => new sfWidgetFormInputText(),
      'password' => new sfWidgetFormInputPassword()
    ));

    $this->setValidators(array(
      'username' => new sfValidatorString(),
      'password' => new sfValidatorString()
    ));
    
    $this->addCSRFProtection(null);
    $this->validatorSchema->setPostValidator(new sfGuardValidatorUser());

    $this->widgetSchema->setNameFormat('signin[%s]');
  }
}

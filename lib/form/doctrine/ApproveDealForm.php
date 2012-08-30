<?php

/**
 * Deal form base class.
 *
 * @method Deal getObject() Returns the current form's model object
 *
 * @package    yiid
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
class ApproveDealForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                    => new sfWidgetFormInputHidden(),
      'target_quantity'       => new sfWidgetFormInputHidden(),
      'price'                 => new sfWidgetFormInputHidden(),
      'commission_pot'        => new sfWidgetFormInputHidden(),
      'commission_per_unit'   => new sfWidgetFormInputHidden(),
      'price_dummy'                 => new sfWidgetFormInputText(),
      'commission_pot_dummy'        => new sfWidgetFormInputText(),
      'commission_per_unit_dummy'   => new sfWidgetFormInputText(),
      'commission_percentage' => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'                    => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'target_quantity'       => new sfValidatorNumber(array('required' => true)),
      'price'                 => new sfValidatorNumber(array('required' => true)),
      'commission_pot'        => new sfValidatorNumber(array('required' => true)),
      'commission_percentage' => new sfValidatorInteger(array('required' => true)),
      'commission_per_unit'   => new sfValidatorNumber(array('required' => true)),
    ));

    $this->widgetSchema->setNameFormat('deal[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Deal';
  }

}

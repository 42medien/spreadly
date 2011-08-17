<?php

/**
 * PaymentMethod form.
 *
 * @package    yiid
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class PaymentMethodForm extends BasePaymentMethodForm
{
  public function configure()
  {

    $lI18n = sfContext::getInstance()->getI18N();
    $this->setWidgets(array(
      //'id'               => new sfWidgetFormInputHidden(),
      //'type'             => new sfWidgetFormChoice(array('choices' => array('invoice' => 'invoice'))),
      '_csrf_token'			=> new sfWidgetFormInputHidden(),
      'company'          => new sfWidgetFormInputText(),
      'contact_name'     => new sfWidgetFormInputText(),
      'address'          => new sfWidgetFormInputText(),
      'city'             => new sfWidgetFormInputText(),
      'zip'              => new sfWidgetFormInputText(),
      'sf_guard_user_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('sfGuardUser'), 'add_empty' => true)),
      //'created_at'       => new sfWidgetFormDateTime(),
      //'updated_at'       => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      //'id'               => new sfValidatorInteger(array('required' => true)),
      //'type'             => new sfValidatorChoice(array('choices' => array(0 => 'invoice'), 'required' => false)),
      'company'          => new sfValidatorString(array('max_length' => 255, 'required' => true)),
      'contact_name'     => new sfValidatorString(array('max_length' => 255, 'required' => true)),
      'address'          => new sfValidatorString(array('max_length' => 255, 'required' => true)),
      'city'             => new sfValidatorString(array('max_length' => 255, 'required' => true)),
      'zip'              => new sfValidatorString(array('max_length' => 255, 'required' => true)),
      'sf_guard_user_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('sfGuardUser'), 'required' => true)),
      //'created_at'       => new sfValidatorDateTime(),
      //'updated_at'       => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setLabels(array(
    	'company' => $lI18n->__('Unternehmen'),
    	'contact_name' => $lI18n->__('Ansprechpartner'),
    	'address' => $lI18n->__('Straße / Postfach'),
      'zip' => $lI18n->__('PLZ'),
      'city' => $lI18n->__('Ort')
    ));

  }
}

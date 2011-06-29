<?php

/**
 * Deal form.
 *
 * @package    yiid_stats
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class CompleteDomainProfileForm extends BaseFormDoctrine
{
  public function configure()
  {
    $this->setWidgets(array(
      'id'                 => new sfWidgetFormInputHidden(),
      'url'                => new sfWidgetFormInputText(),
      'protocol'           => new sfWidgetFormChoice(array('choices' => array('http' => 'http', 'https' => 'https'))),
      'state'              => new sfWidgetFormChoice(array('choices' => array('pending' => 'pending', 'verified' => 'verified'))),
      'verification_token' => new sfWidgetFormInputText(),
      'verification_count' => new sfWidgetFormInputText(),
      'sf_guard_user_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('sfGuardUser'), 'order_by' => array('id', 'DESC'), 'add_empty' => false)),
      'imprint_url'        => new sfWidgetFormTextarea(),
      'tos_url'            => new sfWidgetFormTextarea(),
      'detailed_analytics' => new sfWidgetFormInputCheckbox(),
      'created_at'         => new sfWidgetFormDateTime(array('default' => 'now')),
      'updated_at'         => new sfWidgetFormDateTime(array('default' => 'now'))
    ));
    
    $this->setValidators(array(
      'id'                 => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'url'                => new sfValidatorString(array('max_length' => 255, 'required' => true)),
      'protocol'           => new sfValidatorChoice(array('choices' => array(0 => 'http', 1 => 'https'), 'required' => false)),
      'state'              => new sfValidatorChoice(array('choices' => array(0 => 'pending', 1 => 'verified'), 'required' => false)),
      'verification_token' => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'verification_count' => new sfValidatorInteger(array('required' => false)),
      'sf_guard_user_id'   => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('sfGuardUser'))),
      'imprint_url'        => new sfValidatorString(array('max_length' => 512, 'required' => false)),
      'tos_url'            => new sfValidatorString(array('max_length' => 512, 'required' => false)),
      'detailed_analytics' => new sfValidatorBoolean(array('required' => false)),
      'created_at'         => new sfValidatorDateTime(),
      'updated_at'         => new sfValidatorDateTime(),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'DomainProfile', 'column' => array('verification_token')))
    );

    $this->widgetSchema->setNameFormat('domain_profile[%s]');
    
    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'DomainProfile';
  }

}

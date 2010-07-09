<?php

/**
 * User form base class.
 *
 * @method User getObject() Returns the current form's model object
 *
 * @package    yiid
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseUserForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'              => new sfWidgetFormInputHidden(),
      'username'        => new sfWidgetFormInputText(),
      'passwordhash'    => new sfWidgetFormInputText(),
      'salt'            => new sfWidgetFormInputText(),
      'gender'          => new sfWidgetFormInputText(),
      'salutation'      => new sfWidgetFormInputText(),
      'title'           => new sfWidgetFormInputText(),
      'firstname'       => new sfWidgetFormInputText(),
      'lastname'        => new sfWidgetFormInputText(),
      'sortname'        => new sfWidgetFormInputText(),
      'birthdate'       => new sfWidgetFormDate(),
      'description'     => new sfWidgetFormTextarea(),
      'culture'         => new sfWidgetFormInputText(),
      'agb'             => new sfWidgetFormInputCheckbox(),
      'ip'              => new sfWidgetFormInputText(),
      'active'          => new sfWidgetFormInputCheckbox(),
      'default_avatar'  => new sfWidgetFormInputText(),
      'credentials'     => new sfWidgetFormInputText(),
      'credcommunities' => new sfWidgetFormInputText(),
      'contacts_list'   => new sfWidgetFormTextarea(),
      'friends_list'    => new sfWidgetFormTextarea(),
    ));

    $this->setValidators(array(
      'id'              => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'username'        => new sfValidatorString(array('max_length' => 63, 'required' => false)),
      'passwordhash'    => new sfValidatorString(array('max_length' => 32, 'required' => false)),
      'salt'            => new sfValidatorString(array('max_length' => 8, 'required' => false)),
      'gender'          => new sfValidatorString(array('max_length' => 1, 'required' => false)),
      'salutation'      => new sfValidatorString(array('max_length' => 32, 'required' => false)),
      'title'           => new sfValidatorString(array('max_length' => 64, 'required' => false)),
      'firstname'       => new sfValidatorString(array('max_length' => 64, 'required' => false)),
      'lastname'        => new sfValidatorString(array('max_length' => 64, 'required' => false)),
      'sortname'        => new sfValidatorString(array('max_length' => 128, 'required' => false)),
      'birthdate'       => new sfValidatorDate(array('required' => false)),
      'description'     => new sfValidatorString(array('required' => false)),
      'culture'         => new sfValidatorString(array('max_length' => 7, 'required' => false)),
      'agb'             => new sfValidatorBoolean(array('required' => false)),
      'ip'              => new sfValidatorString(array('max_length' => 128, 'required' => false)),
      'active'          => new sfValidatorBoolean(array('required' => false)),
      'default_avatar'  => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'credentials'     => new sfValidatorString(array('max_length' => 30, 'required' => false)),
      'credcommunities' => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'contacts_list'   => new sfValidatorString(array('required' => false)),
      'friends_list'    => new sfValidatorString(array('required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'User', 'column' => array('username')))
    );

    $this->widgetSchema->setNameFormat('user[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'User';
  }

}

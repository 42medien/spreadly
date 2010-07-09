<?php

/**
 * User filter form base class.
 *
 * @package    yiid
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseUserFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'username'        => new sfWidgetFormFilterInput(),
      'passwordhash'    => new sfWidgetFormFilterInput(),
      'salt'            => new sfWidgetFormFilterInput(),
      'gender'          => new sfWidgetFormFilterInput(),
      'salutation'      => new sfWidgetFormFilterInput(),
      'title'           => new sfWidgetFormFilterInput(),
      'firstname'       => new sfWidgetFormFilterInput(),
      'lastname'        => new sfWidgetFormFilterInput(),
      'sortname'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'birthdate'       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'description'     => new sfWidgetFormFilterInput(),
      'culture'         => new sfWidgetFormFilterInput(),
      'agb'             => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'ip'              => new sfWidgetFormFilterInput(),
      'active'          => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'default_avatar'  => new sfWidgetFormFilterInput(),
      'credentials'     => new sfWidgetFormFilterInput(),
      'credcommunities' => new sfWidgetFormFilterInput(),
      'contacts_list'   => new sfWidgetFormFilterInput(),
      'friends_list'    => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'username'        => new sfValidatorPass(array('required' => false)),
      'passwordhash'    => new sfValidatorPass(array('required' => false)),
      'salt'            => new sfValidatorPass(array('required' => false)),
      'gender'          => new sfValidatorPass(array('required' => false)),
      'salutation'      => new sfValidatorPass(array('required' => false)),
      'title'           => new sfValidatorPass(array('required' => false)),
      'firstname'       => new sfValidatorPass(array('required' => false)),
      'lastname'        => new sfValidatorPass(array('required' => false)),
      'sortname'        => new sfValidatorPass(array('required' => false)),
      'birthdate'       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDateTime(array('required' => false)))),
      'description'     => new sfValidatorPass(array('required' => false)),
      'culture'         => new sfValidatorPass(array('required' => false)),
      'agb'             => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'ip'              => new sfValidatorPass(array('required' => false)),
      'active'          => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'default_avatar'  => new sfValidatorPass(array('required' => false)),
      'credentials'     => new sfValidatorPass(array('required' => false)),
      'credcommunities' => new sfValidatorPass(array('required' => false)),
      'contacts_list'   => new sfValidatorPass(array('required' => false)),
      'friends_list'    => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('user_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'User';
  }

  public function getFields()
  {
    return array(
      'id'              => 'Number',
      'username'        => 'Text',
      'passwordhash'    => 'Text',
      'salt'            => 'Text',
      'gender'          => 'Text',
      'salutation'      => 'Text',
      'title'           => 'Text',
      'firstname'       => 'Text',
      'lastname'        => 'Text',
      'sortname'        => 'Text',
      'birthdate'       => 'Date',
      'description'     => 'Text',
      'culture'         => 'Text',
      'agb'             => 'Boolean',
      'ip'              => 'Text',
      'active'          => 'Boolean',
      'default_avatar'  => 'Text',
      'credentials'     => 'Text',
      'credcommunities' => 'Text',
      'contacts_list'   => 'Text',
      'friends_list'    => 'Text',
    );
  }
}

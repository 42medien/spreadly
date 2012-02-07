<?php

class sfApplySettingsForm extends sfGuardUserForm
{
  public function configure()
  {
    parent::configure();
    $this->removeFields();
/*
    // We're editing the user who is logged in. It is not appropriate
    // for the user to get to pick somebody else's userid, or change
    // the validate field which is part of how their account is
    // verified by email. Also, users cannot change their email
    // addresses as they are our only verified connection to the user.


        $this->setWidget( 'username',
                new sfWidgetFormInput( array(), array( 'maxlength' => 16 ) ) );
        $this->widgetSchema->moveField('username', sfWidgetFormSchema::FIRST);


        //Firstname and lastname
        $this->setWidget( 'firstname', new sfWidgetFormInputText( array(), array( 'maxlength' => 30 ) ) );
        $this->widgetSchema->moveField('firstname', sfWidgetFormSchema::AFTER, 'username');
        $this->setWidget( 'lastname', new sfWidgetFormInputText( array(), array( 'maxlength' => 70 ) ) );
        $this->widgetSchema->moveField('lastname', sfWidgetFormSchema::AFTER, 'firstname');


        $this->widgetSchema->setLabels( array(
            'username' => 'Username',
            'firstname' => 'First Name',
            'lastname' => 'Last name'
        ) );

    $this->setValidator( 'firstname' , new sfValidatorApplyFirstname() );
    $this->setValidator( 'lastname', new sfValidatorApplyLastname() );
    $this->setValidator( 'username', new sfValidatorApplyUsername() );*/


    $this->widgetSchema->setNameFormat('sfApplySettings[%s]');
    $this->widgetSchema->setFormFormatterName('table');


  }

  protected function removeFields()
  {
    unset(
        $this['id'],
        $this['email_address'],
        $this['algorithm'],
        $this['salt'],
        $this['password'],
        $this['is_active'],
        $this['is_super_admin'],
        $this['last_login'],
        $this['access_token'],
        $this['api_price_like'],
        $this['api_price_media_penetration'],
        $this['api_commission_percentage'],
        $this['created_at'],
        $this['updated_at'],
        $this['groups_list'],
        $this['permissions_list']
    );
  }
}
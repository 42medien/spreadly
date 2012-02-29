<?php

//Changing it to like ValidatorAnd could allow us to add check for existance of special characters if required
class sfValidatorResetPassword extends sfValidatorBase
{

  public function configure($options = array(), $messages = array())
  {
    $this->addOption('username_field', 'username');
    $this->addOption('password_field', 'old_password');
    $this->addOption('throw_global_error', false);

    $this->setMessage('invalid', 'Your old password is invalid.');
  }


  protected function doClean($values)
  {

  	//var_dump($values);die();
    $username = isset($values[$this->getOption('username_field')]) ? $values[$this->getOption('username_field')] : '';
    $password = isset($values[$this->getOption('password_field')]) ? $values[$this->getOption('password_field')] : '';


    //$allowEmail = sfConfig::get('app_sf_guard_plugin_allow_login_with_email', true);
    $method = 'retrieveByUsername';

    // don't allow to sign in with an empty username
    if ($username)
    {
       if ($callable = sfConfig::get('app_sf_guard_plugin_retrieve_by_username_callable'))
       {
           $user = call_user_func_array($callable, array($username));
       } else {
           $user = $this->getTable()->$method($username);
       }
        // user exists?
       if($user)
       {

       	// password is ok?
          if ($user->getIsActive() && $user->checkPassword($password))
          {
            return array_merge($values, array('user' => $user));
          }
       }
    }

    if ($this->getOption('throw_global_error'))
    {
      throw new sfValidatorError($this, 'invalid');
    }

    throw new sfValidatorErrorSchema($this, array($this->getOption('password_field') => new sfValidatorError($this, 'invalid')));
  }

  protected function getTable()
  {
    return Doctrine::getTable('sfGuardUser');
  }

}

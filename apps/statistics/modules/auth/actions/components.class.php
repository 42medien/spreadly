<?php

class authComponents extends sfComponents {
	
  public function executeLogin_box(sfWebRequest $request) {
    $class = sfConfig::get('app_sf_guard_plugin_signin_form', 'sfGuardFormSignin'); 
    $this->form = new $class();
  }
}
?>
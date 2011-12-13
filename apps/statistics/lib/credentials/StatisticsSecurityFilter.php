<?php
class StatisticsSecurityFilter extends sfBasicSecurityFilter {

  public function execute($filterChain) {
    // NOTE: the nice thing about the Action class is that getCredential()
    //       is vague enough to describe any level of security and can be
    //       used to retrieve such data and should never have to be altered
    if (!$this->context->getUser()->isAuthenticated())
    {
      if (sfConfig::get('sf_logging_enabled'))
      {
        $this->context->getEventDispatcher()->notify(new sfEvent($this, 'application.log', array(sprintf('Action "%s/%s" requires authentication, forwarding to "%s/%s"', $this->context->getModuleName(), $this->context->getActionName(), sfConfig::get('sf_login_module'), sfConfig::get('sf_login_action')))));
      }

      /*if ($this->context->getRequest()->getReferer()) {
        // load special login page
      } elseif ($this->context->getRequest()->getReferer()) {
        // load special login page
      }*/
      // the user is not authenticated
      $this->forwardToLoginAction();
    }

    $credential = $this->getUserCredential();

    $lib = $this->toCamelCase($credential)."Credentials";

    if (class_exists($lib)) {
      call_user_func(array($lib, "verify"));
      $filterChain->execute();
      return;
    } else {
      parent::execute($filterChain);
    }
  }

  /**
   * Translates a string with underscores into camel case (e.g. first_name -> firstName)
   *
   * @param string $str String in underscore format
   * @param bool $capitalise_first_char If true, capitalise the first char in $str
   * @return string $str translated into camel caps
   */
  public function toCamelCase($str, $capitalise_first_char = true) {
    if($capitalise_first_char) {
      $str[0] = strtoupper($str[0]);
    }
    $func = create_function('$c', 'return strtoupper($c[1]);');
    return preg_replace_callback('/_([a-z])/', $func, $str);
  }
}
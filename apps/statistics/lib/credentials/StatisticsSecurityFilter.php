<?php
class StatisticsSecurityFilter extends sfBasicSecurityFilter {

  public function execute($filterChain) {
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
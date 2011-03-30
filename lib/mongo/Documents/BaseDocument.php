<?php
namespace Documents;

class BaseDocument {
  /**
   * magic getter/setter
   *
   * @param string $name
   * @param array $parameterArray
   * @return mixed
   */
  public function __call($name, $parameterArray) {
    $case = substr($name, 0, 3);
    $attribute = $this->fromCamelCase(substr($name, 3));

    switch ($case) {
      case "set":
        if (property_exists($this, $attribute)) {
          $this->$attribute = $parameterArray[0];
          return true;
        } else {
          return false;
        }
        break;
      case "get":
        if (property_exists($this, $attribute)) {
          $vars = get_object_vars($this);
          return $vars[$attribute];
        } else {
          return false;
        }
        break;
    }
  }

  /**
   * ninja fromArray method
   *
   * @param array $array
   */
  public function fromArray($array = array()) {
    foreach ($array as $key => $value) {
      $function = "set".$this->toCamelCase($key);

      if (method_exists($this, $function)) {
        call_user_func(array($this, $function), $value);
      }
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

  /**
   * Translates a camel case string into a string with underscores (e.g. firstName -> first_name)
   *
   * @param string $str String in camel case format
   * @return string $str Translated into underscore format
   */
  public function fromCamelCase($str) {
    $str[0] = strtolower($str[0]);
    $func = create_function('$c', 'return "_" . strtolower($c[1]);');
    return preg_replace_callback('/([A-Z])/', $func, $str);
  }
}
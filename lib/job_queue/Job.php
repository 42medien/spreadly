<?php
/**
 * Job
 *
 * @author Hannes Schippmann
 */
abstract class Job {
  private $type;
  
  public function __construct() {
    $this->type = $this->fromCamelCase($this->get_class());
  }
  
  abstract public function fromArray($array);

  abstract public function toArray();
  
  abstract public function execute();
  
  protected function preExecute() {
    $this->log('Executing.');
    // how do you call these methods in php?
  }

  protected function postExecute() {
    $this->log('Done.');
    // how do you call these methods in php?
  }

  protected function log($message) {
    System_Daemon::log('{'.$this->fromCamelCase($this->type).'} '.$message);
  }
  
  /**
   * Translates a string with underscores into camel case (e.g. first_name -> firstName)
   * Undry copy of mongo/BaseDocument
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
   * Undry copy of mongo/BaseDocument
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

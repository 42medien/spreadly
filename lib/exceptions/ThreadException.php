<?php
/**
 * the thread-exception
 *
 */
class ThreadException extends sfException {

  const UNKNOWN_ERROR                   = 1;
  const NO_SCRIPT_DEFINED               = 2;
  const ONLY_PRIMITIVES_ALLOWED         = 3;

  private $aName;


  /**
   *
   */
  public function __construct($message = null, $error_code = 1) {
    $this->setName('ThreadException');

    try {
      sfContext::getInstance()->getLogger()->err($message);
    } catch (Exception $e) {}

    parent::__construct($message, $error_code);
  }

  /**
   * show the class, where the error was thrown
   *
   * @return string class-name
   */
  public function getClass() {
    $trace = $this->getTrace();
    return $trace[0]['class'];
  }


  public function setName( $pName ){
    $this->aName = $pName;
  }

  public function getName(){
    return $this->aName;
  }


}
?>

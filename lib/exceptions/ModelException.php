<?php
/**
 * the model-exception
 *
 */
class ModelException extends sfException {

  const NOT_FOUND               = 1;
  const DUPLICATE               = 2;
  const NOT_ALLOWED             = 3;
  const UPLOAD_ERROR	          = 4;
  const ATTRIBUTE_REQUIRED      = 5;
  const INVALID_ACTION          = 6;

  private $aName;


  /**
   *
   */
  public function __construct($message = null, $error_code = 0) {
    $this->setName('ModelException');

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

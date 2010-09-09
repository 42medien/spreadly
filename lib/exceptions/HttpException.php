<?php
/**
 * http-exception
 *
 * @see http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html
 */
class HttpException extends sfException {

  private $aName;

  /**
   *
   */
  public function __construct($message = null, $http_error_code = 0) {
    $this->setName('HttpException');

    try {
      sfContext::getInstance()->getLogger()->err($message);
    } catch (Exception $e) {}

    parent::__construct($message, $http_error_code);
  }

  public function setName( $pName ){
    $this->aName = $pName;
  }

  public function getName(){
    return $this->aName;
  }
}

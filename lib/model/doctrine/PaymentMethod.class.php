<?php

/**
 * PaymentMethod
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    yiid
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class PaymentMethod extends BasePaymentMethod
{
  public function __toString() {
    return $this->getCompany()."<br/>".
           $this->getContactName()."<br/>".
           $this->getAddress()."<br/>".
           $this->getZip()." ".$this->getCity();
  }
}

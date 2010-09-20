<?php

class sfMessageSource_pimpedMySQL extends sfMessageSource_MySQL
{

  
  /**
   * we need this adapted MessageSource File in order to fix the utf-8 umlauts problem.
   * 
   *  The regular MySQL connector class doesn't support the parameters to set the charset while transmission
   * 
   * @param $source
   * @return unknown_type
   */
  function __construct($source)
  {
    parent::__construct($source);
    
    mysql_query("SET CHARACTER SET utf8", $this->db);
    mysql_query("SET NAMES utf8", $this->db);
    
  }
  
  
}

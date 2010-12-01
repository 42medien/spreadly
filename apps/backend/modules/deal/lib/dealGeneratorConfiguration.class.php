<?php

/**
 * deal module configuration.
 *
 * @package    yiid
 * @subpackage deal
 * @author     Your name here
 * @version    SVN: $Id: configuration.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class dealGeneratorConfiguration extends BaseDealGeneratorConfiguration
{
  public function getFormClass()
  {
    return 'CompleteDealForm';
  }

}

<?php

/**
 * system components.
 *
 * @package    yiid
 * @subpackage system
 * @author     Christian Schätzle
 */

class systemComponents extends sfComponents
{
  public function executeLanguage_switch(sfWebRequest $request)
  {
    $this->form = new sfFormLanguage(
      $this->getUser(),
      array('languages' => array('en', 'de'))
    );
  }
}
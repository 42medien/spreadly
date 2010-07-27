<?php

class generalComponents extends sfComponents {


  public function executeFooter() {
    $culture = $this->getUser()->getCulture();
    if ($culture) {
      $culture = substr($culture, 0, 2);
    } else {
      $culture = 'de';
    }


    $this->categories = $lcategories = array();
    $this->culture = $culture;

  }


  public function executeLanguage_switch(sfWebRequest $request) {
    $this->form = new sfFormLanguage(
      $this->getUser(),
      array('languages' => array('en', 'de'))
    );
  }
}
?>
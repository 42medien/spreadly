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


}
?>
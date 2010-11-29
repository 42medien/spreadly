<?php

class generalComponents extends sfComponents {

  public function executeFooter() {}

  public function executeLanguage_switch(sfWebRequest $request) {
    $this->form = new sfFormLanguage(
      $this->getUser(),
      array('languages' => array('en', 'de'))
    );
  }
}
?>
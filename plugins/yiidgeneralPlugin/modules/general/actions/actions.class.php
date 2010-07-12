<?php
class generalActions extends sfActions {

  /**
   * Executes index action
   *
   */
  public function executeIndex() {
  }

  /**
   * Executes index action
   *
   */
  public function executeJs_log(sfWebRequest $pRequest) {
    $this->getResponse()->setContentType('application/json');
     file_put_contents(sfConfig::get('sf_log_dir').'/javascript.log', 'affen', FILE_APPEND);
  }
}

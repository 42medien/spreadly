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
    $lMsg = $pRequest->getParameter('msg', 'snirgel sitzt im');
    $lUa = $pRequest->getParameter('useragent', 'affenstall');
    $this->getResponse()->setContentType('application/json');
    file_put_contents(sfConfig::get('sf_log_dir').'/javascript.log', date('Y-m-d H:i') . ' - ' .$lMsg . ' - ' . $lUa . "\r\n", FILE_APPEND);
    return sfView::NONE;
  }
}

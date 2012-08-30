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
  
  /**
   * action for language switch
   * @author Christian Schätzle
   */
  public function executeChangeLanguage(sfWebRequest $request) {
    
    $form = new sfFormLanguage(
      $this->getUser(),
      array('languages' => array('en', 'de'))
    );
 
    $form->process($request);
 
    $referer = $this->getRequest()->getReferer();

    if( preg_match('/yiid/', parse_url($referer, PHP_URL_HOST)) ) {
      return $this->redirect( $referer );
    } else {
      return $this->redirect( 'index/index' );
    }
  }
}

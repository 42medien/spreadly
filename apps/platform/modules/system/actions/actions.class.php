<?php

/**
 * system actions.
 *
 * @package    yiid
 * @subpackage system
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class systemActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request) {
  	
  }
  

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

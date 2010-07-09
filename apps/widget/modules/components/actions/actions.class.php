<?php
/**
 * compontents
 *
 * @package    communipedia
 * @subpackage frontend-modules
 * @version    $Id$
 * @copyright  (c) 2009 ekaabo GmbH
 */
class componentsActions extends sfActions
{

  public function executeLanguage() {
    $culture = $this->getRequestParameter('lang');

    $this->getUser()->switchLanguage($culture);

    $referer = $this->getRequest()->getReferer();

    if( preg_match('/yiid/', parse_url($referer, PHP_URL_HOST)) ) {
      $this->redirect( $referer );
    } else {
      $this->redirect( 'http://www.yiid.it' );
    }
  }

  private function getCulture() {
    $culture = $this->getUser()->getCulture();

    return $culture;
  }
}

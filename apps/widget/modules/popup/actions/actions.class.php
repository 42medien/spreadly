<?php

/**
 * popup actions.
 *
 * @package    yiid
 * @subpackage popup
 * @author     Matthias Pfefferle
 * @author     Christian Schätzle
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class popupActions extends sfActions {

  public function executeError(sfWebRequest $request) {
    $this->getResponse()->setSlot('js_document_ready', $this->getPartial('popup/js_popup_ready'));
    sfProjectConfiguration::getActive()->loadHelpers('I18N');
    $this->getUser()->setFlash('headline', __('ERROR', null, 'widget'));

    $this->getUser()->setFlash('error', 'Folgede Fehler sind aufgetreten:');
  }

  public function executeSettings(sfWebRequest $request) {
    $this->getResponse()->setSlot('js_document_ready', $this->getPartial('popup/js_popup_ready'));
    $this->getUser()->setFlash('headline', __('SETTINGS', null, 'widget'));
    $this->setLayout('layout_twocol');
  }

  public function executeGet_settings(sfWebRequest $request) {
    $this->getResponse()->setContentType('application/json');
    return $this->renderText(
      json_encode(
        array(
          'success' => true,
          'html'  => $this->getComponent('popup','settings'),
        )
      )
    );
  }
}

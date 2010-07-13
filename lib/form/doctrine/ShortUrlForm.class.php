<?php

/**
 * ShortUrl form.
 *
 * @package    yiid
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ShortUrlForm extends BaseShortUrlForm
{
  public function configure() {
    $this->setWidgets(array(
      'url'     => new sfWidgetFormInput(array(), array('class' => 'inputtext'))
    ));

    $this->widgetSchema->setNameFormat('shorturl[%s]');
    $this->widgetSchema->setLabels(array(
      'url' => sfContext::getInstance()->getI18N()->__('SHORT_URL_LABEL')
    ));

    $this->setValidatorSchema(new sfValidatorSchema(array(
      'url' => new sfValidatorUrl(array(), array('invalid' => sfContext::getInstance()->getI18N()->__('URL_INVALID'), 'required' => sfContext::getInstance()->getI18N()->__('URL_REQUIRED')))
    )));
  }
}

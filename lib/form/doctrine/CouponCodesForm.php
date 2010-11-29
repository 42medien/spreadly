<?php

/**
 * Coupon codes form.
 *
 * @package    yiid_stats
 * @subpackage form
 * @author     hannes
 */
class CouponCodesForm extends BaseForm {

  public function setup() {
    $lI18n = sfContext::getInstance()->getI18N();

    $this->setWidgets(array(
      'single_code'           => new sfWidgetFormInputText(),
      'multiple_codes'        => new sfWidgetFormTextarea()

    ));

    $this->setValidators(array(
      'single_code'           => new sfValidatorString(),
      'multiple_codes'        => new sfValidatorString()
    ));
    
    $this->widgetSchema->setNameFormat('coupon[%s]');

    parent::setup();
  }
}

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
      'single_code'           => new sfValidatorString(array("required" => false)),
      'multiple_codes'        => new sfValidatorString(array("required" => false))
    ));
    
    $this->getValidatorSchema()->setPostValidator(
      new sfValidatorOr(array(
        new sfValidatorSchemaFilter('single_code', new sfValidatorString(array('required' => true))),
        new sfValidatorSchemaFilter('multiple_codes', new sfValidatorString(array('required' => true)))
      ))
    );
  
    $this->widgetSchema->setNameFormat('coupon[%s]');

    parent::setup();
  }
}

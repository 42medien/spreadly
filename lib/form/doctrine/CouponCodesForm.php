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
      'single_code'           => new sfValidatorString(array("required" => false, 'trim' => true)),
      'multiple_codes'        => new sfValidatorString(array("required" => false, 'trim' => true))
    ));

    $this->getValidatorSchema()->setPostValidator(
      new sfValidatorOr(array(
        new sfValidatorSchemaFilter('single_code', new sfValidatorString(array('required' => true), array('required' => $lI18n->__('Required')))),
        new sfValidatorSchemaFilter('multiple_codes', new sfValidatorString(array('required' => true), array('required' => $lI18n->__('Required'))))
      ))
    );

    $this->widgetSchema->setNameFormat('coupon[%s]');

    parent::setup();
  }
}

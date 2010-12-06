<?php

/**
 * Deal form.
 *
 * @package    yiid_stats
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class DealForm extends BaseDealForm
{
  public function configure()
  {

    $lI18n = sfContext::getInstance()->getI18N();

    $this->setWidgets(array(
      'id'                => new sfWidgetFormInputHidden(),
			'sf_guard_user_id'  => new sfWidgetFormInputHidden(),
      'domain_profile_id' => new sfWidgetFormInputHidden(),
      'start_date'        => new sfWidgetFormInputText(),
      'end_date'          => new sfWidgetFormInputText(),
      'summary'           => new sfWidgetFormInputText(),
      'description'       => new sfWidgetFormInputText(),
      'button_wording'    => new sfWidgetFormInputText(),
      'coupon_quantity'    => new sfWidgetFormInputText(),
      'coupon_type'       => new sfWidgetFormChoice(array('choices' => array('single' => $lI18n->__('Only one code'), 'multiple' => $lI18n->__('Paste codes')), 'expanded' => true ), array('class' => 'coupon-type-select')),
      'redeem_url'        => new sfWidgetFormInputText(),
      'tos_accepted'      => new sfWidgetFormInputCheckbox(),
      'terms_of_deal'     => new sfWidgetFormInputText()
    ));

    $this->setDefaults(
    	array(
    		'start_date' => date('Y-m-d G:i'),
    		'end_date' => date('Y-m-d G:i')
    	)
    );

    $this->widgetSchema->setLabels(
    	array(
    		'tos_accepted' => 'By submitting a deal you accept the Yiid %terms% Agreement.'
    	)
    );

    $this->setValidators(array(
      'id'                => new sfValidatorInteger(array('required' => false), array('required' => $lI18n->__('Required'))),
      'domain_profile_id' => new sfValidatorInteger(array('required' => false), array('required' => $lI18n->__('Required'))),
      'sf_guard_user_id' => new sfValidatorInteger(array('required' => false), array('required' => $lI18n->__('Required'))),
      'start_date'        => new sfValidatorPass(array('required' => true, 'trim' => true), array('required' => $lI18n->__('Required'))),
      'end_date'          => new sfValidatorPass(array('required' => true, 'trim' => true), array('required' => $lI18n->__('Required'))),
      'summary'           => new sfValidatorString(array('max_length' => 40, 'required' => true, 'trim' => true), array('required' => $lI18n->__('Required'))),
      'description'       => new sfValidatorString(array('max_length' => 80, 'required' => true, 'trim' => true), array('required' => $lI18n->__('Required'))),
      'button_wording'    => new sfValidatorString(array('max_length' => 35, 'required' => true, 'trim' => true), array('required' => $lI18n->__('Required'))),
      'coupon_quantity'    => new sfValidatorInteger(array('required' => false, 'trim' => true)),
      'coupon_type'       => new sfValidatorChoice(array('choices' => array(0 => 'single', 1 => 'multiple'))),
      'redeem_url'        => new sfValidatorString(array('max_length' => 512, 'required' => false, 'trim' => true)),
      'tos_accepted'      => new sfValidatorBoolean(array('required' => true, 'trim' => true), array('required' => $lI18n->__('Required'))),
      'terms_of_deal'     => new sfValidatorUrl(array('max_length' => 512, 'required' => true, 'trim' => true), array('required' => $lI18n->__('Required'), 'invalid' => $lI18n->__('Invalid Url')))
    ));
    
    $this->validatorSchema->setPostValidator(new CouponQuantityValidator());
    
    //$this->widgetSchema->setNameFormat('deal[%s]');
  }
}

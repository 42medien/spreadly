<?php

/**
 * Deal form.
 *
 * @package    yiid_stats
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class CreateDealForm extends BaseDealForm
{
  public function configure()
  {

    //$lI18n = sfContext::getInstance()->getI18N();

    $this->setWidgets(array(
      //'id'                => new sfWidgetFormInputHidden(),
      //'type'              => new sfWidgetFormChoice(array('choices' => array('pool' => 'pool'))),
      'name'              => new sfWidgetFormInputText(),
      'tos_accepted'      => new sfWidgetFormInputCheckbox(),
      'motivation_title'  => new sfWidgetFormInputText(),
      'motivation_text'   => new sfWidgetFormTextarea(),
      'spread_title'      => new sfWidgetFormInputText(),
      'spread_text'       => new sfWidgetFormTextarea(),
      'spread_url'        => new sfWidgetFormInputText(),
      'spread_img'        => new sfWidgetFormInputText(),
      'spread_tos'        => new sfWidgetFormInputText(),
      'coupon_type'       => new sfWidgetFormChoice(array('choices' => array('code' => 'code', 'url' => 'url', 'download' => 'download'))),
      'coupon_title'      => new sfWidgetFormInputText(),
      'coupon_text'       => new sfWidgetFormTextarea(),
      'coupon_code'       => new sfWidgetFormInputText(),
      'coupon_url'        => new sfWidgetFormInputText(),
      'coupon_redeem_url' => new sfWidgetFormInputText(),
      //'billing_type'      => new sfWidgetFormChoice(array('choices' => array('like' => 'like', 'media_penetration' => 'media_penetration'))),
      'target_quantity'   => new sfWidgetFormInputText(),
      //'actual_quantity'   => new sfWidgetFormInputText(),
      'sf_guard_user_id'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('sfGuardUser'), 'add_empty' => true)),
      //'payment_method_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('PaymentMethod'), 'add_empty' => false)),
      //'domain_profile_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('DomainProfile'), 'add_empty' => true)),
      'created_at'        => new sfWidgetFormDateTime(),
      //'updated_at'        => new sfWidgetFormDateTime(),
      //'deal_state'        => new sfWidgetFormChoice(array('choices' => array('initial' => 'initial', 'submitted' => 'submitted', 'approved' => 'approved', 'denied' => 'denied', 'trashed' => 'trashed', 'paused' => 'paused'))),
    ));



    /*
    $this->setValidators(array(
      'id'                => new sfValidatorInteger(array('required' => false), array('required' => $lI18n->__('Required'))),
      'domain_profile_id' => new sfValidatorInteger(array('required' => false), array('required' => $lI18n->__('Required'))),
      'sf_guard_user_id' => new sfValidatorInteger(array('required' => false), array('required' => $lI18n->__('Required'))),
      'start_date'        => new sfValidatorPass(array('required' => true, 'trim' => true), array('required' => $lI18n->__('Required'))),
      'end_date'          => new sfValidatorPass(array('required' => true, 'trim' => true), array('required' => $lI18n->__('Required'))),
      'summary'           => new sfValidatorString(array('max_length' => 40, 'required' => true, 'trim' => true), array('required' => $lI18n->__('Required'), 'max_length' => $lI18n->__('To long'))),
      'description'       => new sfValidatorString(array('max_length' => 80, 'required' => true, 'trim' => true), array('required' => $lI18n->__('Required'), 'max_length' => $lI18n->__('To long'))),
      'button_wording'    => new sfValidatorString(array('max_length' => 110, 'required' => true, 'trim' => true), array('required' => $lI18n->__('Required'), 'max_length' => $lI18n->__('To long'))),
      'coupon_quantity'   => new sfValidatorInteger(array('required' => false, 'trim' => true)),
    	'tags'              => new sfValidatorString(array('max_length' => 512, 'required' => false)),
      'coupon_type'       => new sfValidatorChoice(array('choices' => array(0 => 'single', 1 => 'multiple', 2 => 'url'))),
			'addtags'           => new sfValidatorChoice(array('choices' => array(0 => 'addtags', 1 => 'addnotags'), 'min' => 0)),
      'redeem_url'        => new sfValidatorUrl(array('max_length' => 512, 'required' => true, 'trim' => true)),
      'tos_accepted'      => new sfValidatorBoolean(array('required' => true, 'trim' => true), array('required' => $lI18n->__('Required'))),
      'terms_of_deal'     => new sfValidatorUrl(array('max_length' => 512, 'required' => true, 'trim' => true), array('required' => $lI18n->__('Required'), 'invalid' => $lI18n->__('Invalid Url')))
    ));

    $this->validatorSchema->setPostValidator(new sfValidatorAnd(
      array(
        new CouponQuantityValidator(),
        new EndDateValidator(),
        new OverlappingDealValidator()
      ))
    );*/

    //$this->widgetSchema->setNameFormat('deal[%s]');
  }

  public function validate_campaign(){
    $this->setValidators(array(
      'name'              => new sfValidatorString(array('max_length' => 255, 'required' => true)),
      'sf_guard_user_id'  => new sfValidatorInteger(array('required' => true)),
      'target_quantity'   => new sfValidatorInteger(array('required' => true))
    ));
  }

  public function validate_share(){
    $this->setValidators(array(
      'motivation_title'  => new sfValidatorString(array('max_length' => 255, 'required' => true)),
      'motivation_text'   => new sfValidatorString(array('required' => true)),
      'spread_title'      => new sfValidatorString(array('max_length' => 255, 'required' => true)),
      'spread_text'       => new sfValidatorString(array('required' => true)),
      'spread_url'        => new sfValidatorString(array('max_length' => 255, 'required' => true)),
      'spread_img'        => new sfValidatorString(array('max_length' => 255, 'required' => true)),
      'spread_tos'        => new sfValidatorString(array('max_length' => 255, 'required' => true))
    ));
  }

  public function validate_coupon(){
    $this->setValidators(array(
      'coupon_type'       => new sfValidatorChoice(array('choices' => array(0 => 'code', 1 => 'url', 2 => 'download'), 'required' => true)),
      'coupon_title'      => new sfValidatorString(array('max_length' => 255, 'required' => true)),
      'coupon_text'       => new sfValidatorString(array('required' => true)),
      'coupon_code'       => new sfValidatorString(array('max_length' => 255, 'required' => true)),
      'coupon_url'        => new sfValidatorString(array('max_length' => 255, 'required' => true)),
      'coupon_redeem_url' => new sfValidatorString(array('max_length' => 255, 'required' => true))
    ));
  }

  public function validate_billing(){
    $this->setValidators(array(
    	'tos_accepted'      => new sfValidatorBoolean(array('required' => true))
    ));
    //$this->se
  }
}

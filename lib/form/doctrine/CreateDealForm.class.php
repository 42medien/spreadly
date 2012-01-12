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
    sfContext::getInstance()->getConfiguration()->loadHelpers(array('YiidNumber'));
    $lI18n = sfContext::getInstance()->getI18N();

    // generate prices
    $likes = sfConfig::get("app_deal_pricing_like");
    $like_fields = array();
    foreach ($likes as $key => $value) {
      $like_fields[$key] = $lI18n->__(point_format($key)." likes for $value €");
    }

    $mp = sfConfig::get("app_deal_pricing_media_penetration");
    $mp_fields = array();
    foreach ($mp as $key => $value) {
      $mp_fields[$key] = $lI18n->__(point_format($key)." for $value €");
    }


    $this->setWidgets(array(
      //'id'                => new sfWidgetFormInputHidden(),
      //'type'              => new sfWidgetFormChoice(array('choices' => array('pool' => 'pool'))),
      'name'              => new sfWidgetFormInputText(),
      'domain_profile_id' => new sfWidgetFormChoice(array('choices' => array(), 'expanded' => true)),
      'type'              => new sfWidgetFormChoice(array('choices' => array('pool' => $lI18n->__('Überall'), 'publisher' => $lI18n->__('Domain')), 'expanded' => true)),
    	'tos_accepted'      => new sfWidgetFormInputCheckbox(),
      'motivation_title'  => new sfWidgetFormInputText(),
      'motivation_text'   => new sfWidgetFormTextarea(),
      'spread_title'      => new sfWidgetFormInputText(),
      'spread_text'       => new sfWidgetFormTextarea(),
      'spread_url'        => new sfWidgetFormInputText(),
      'spread_img'        => new sfWidgetFormInputText(),
      'spread_tos'        => new sfWidgetFormInputText(),
      'coupon_type'       => new sfWidgetFormChoice(array('choices' => array('code' => $lI18n->__('Code'), 'url' => $lI18n->__('Url'), 'download' => $lI18n->__('Download'), 'unique_code' => $lI18n->__('Unique')), 'expanded' => true)),
      'coupon_title'      => new sfWidgetFormInputText(),
      'coupon_text'       => new sfWidgetFormTextarea(),
      'coupon_code'       => new sfWidgetFormInputText(),
      'coupon_url'        => new sfWidgetFormInputText(),
      'coupon_redeem_url' => new sfWidgetFormInputText(),
      'coupon_webhook_url'=> new sfWidgetFormInputText(),
    	'billing_type'			=> new sfWidgetFormInputHidden(),
      'target_quantity'   => new sfWidgetFormChoice(array('choices' => $like_fields, 'expanded' => true )),
      'target_quantity_mp'   => new sfWidgetFormChoice(array('choices' => $mp_fields, 'expanded' => true )),
      //'actual_quantity'   => new sfWidgetFormInputText(),
      'sf_guard_user_id'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('sfGuardUser'), 'add_empty' => true)),
      'payment_method_id' => new sfWidgetFormInputHidden(),
    	/*
      'payment_method_id' => new sfWidgetFormDoctrineChoice(array(
      														'model' => $this->getRelatedModelName('PaymentMethod'),
      														'add_empty' => false,
      														'expanded' => true
    															//'renderer_class' => 'WidgetPmSelect'
    														)),*/
      //'domain_profile_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('DomainProfile'), 'add_empty' => true)),
      'created_at'        => new sfWidgetFormDateTime(),
      //'updated_at'        => new sfWidgetFormDateTime(),
      //'deal_state'        => new sfWidgetFormChoice(array('choices' => array('initial' => 'initial', 'submitted' => 'submitted', 'approved' => 'approved', 'denied' => 'denied', 'trashed' => 'trashed', 'paused' => 'paused'))),
    ));

    $this->setDefault('target_quantity', '10');

    $this->widgetSchema->setLabels(array(
    	'name' => $lI18n->__('Name'),
    	'type' => $lI18n->__('Art des Deals'),
    	'domain_profile_id' => $lI18n->__('Domain'),
    	'target_quantity' => $lI18n->__('Streuung nach Likes'),
    	'target_quantity_mp' => $lI18n->__('Streuung nach Reichweite'),
    	'motivation_title' => $lI18n->__('Motivator'),
    	'motivation_text' => $lI18n->__('Motivationstext'),
    	'spread_title' => $lI18n->__('Spread Werbung'),
    	'spread_url' => $lI18n->__('Spread URL'),
    	'spread_text' => $lI18n->__('Spread Teaser'),
    	'spread_img' => $lI18n->__('Spread Bild'),
    	'spread_tos' => $lI18n->__('Spread AGB'),
    	'coupon_title' => $lI18n->__('Name des Gutscheins'),
    	'coupon_text' => $lI18n->__('Gutscheintext'),
    	'coupon_type' => $lI18n->__('Gutscheinquelle'),
    	'coupon_code' => $lI18n->__('Gutschein Code'),
    	'coupon_redeem_url' => $lI18n->__('Gutschein einlösen'),
    	'coupon_webhook_url' => $lI18n->__('Webhook URL'),
    	'coupon_url' => $lI18n->__('Gutschein/Download URL'),
    	'tos_accepted' => $lI18n->__('Ich aktzeptiere <a href="http://www.spreadly.com/system/tos" target="_blank">die Allgemeinen Geschäftsbedingungen</a> von Spreadly.'),
    ));

  }

  public function validate_campaign(){
    $lI18n = sfContext::getInstance()->getI18N();
    $this->setValidators(array(
      'name'              => new sfValidatorString(array('max_length' => 255, 'required' => true), array('required' => $lI18n->__('Bitte tragen sie einen Kampagnen-Namen ein')) ),
      'sf_guard_user_id'  => new sfValidatorInteger(array('required' => true)),
      'target_quantity'   => new sfValidatorInteger(array('required' => false)),
    	'target_quantity_mp'   => new sfValidatorInteger(array('required' => false)),
    	'billing_type'   => new sfValidatorString(array('required' => true)),
    	'domain_profile_id'   => new sfValidatorInteger(array('required' => false)),
			'type'   => new sfValidatorString(array('required' => true), array('invalid' => $lI18n->__('Nicht möglich'))),
    ));

    $this->validatorSchema->setPostValidator(new sfValidatorAnd(
      array(
        new DealTypeValidator()
    )));

  }

  public function validate_share(){
    $lI18n = sfContext::getInstance()->getI18N();
    $this->setValidators(array(
      'motivation_title'  => new sfValidatorString(array('max_length' => 255, 'required' => true), array('required' => $lI18n->__('Required'), 'max_length' => $lI18n->__('To long'))),
      'motivation_text'   => new sfValidatorString(array('required' => true, 'max_length' => 255), array('required' => $lI18n->__('Required'))),
      'spread_title'      => new sfValidatorString(array('max_length' => 255, 'required' => true), array('required' => $lI18n->__('Required'), 'max_length' => $lI18n->__('To long'))),
      'spread_text'       => new sfValidatorString(array('required' => true), array('required' => $lI18n->__('Required'))),
      'spread_url'        => new sfValidatorUrl(array('max_length' => 255, 'required' => true, 'trim' => true), array('required' => $lI18n->__('URL required'))),
      'spread_img'        => new sfValidatorUrl(array('max_length' => 255, 'required' => true, 'trim' => true), array('required' => $lI18n->__('URL required'))),
      'spread_tos'        => new sfValidatorUrl(array('max_length' => 255, 'required' => true, 'trim' => true), array('required' => $lI18n->__('URL required')))
    ));
  }

  public function validate_coupon(){
  	$lI18n = sfContext::getInstance()->getI18N();
    $this->setValidators(array(
      'coupon_type'       => new sfValidatorChoice(array('choices' => array(0 => 'code', 1 => 'url', 2 => 'download', 3 => 'unique_code'), 'required' => true)),
      'coupon_title'      => new sfValidatorString(array('max_length' => 255, 'required' => true), array('required' => $lI18n->__('Required'), 'max_length' => $lI18n->__('To long'))),
      'coupon_text'       => new sfValidatorString(array('required' => true, 'max_length' => 255), array('required' => $lI18n->__('Required'))),
      'coupon_code'       => new sfValidatorString(array('max_length' => 255, 'required' => false), array('required' => $lI18n->__('Required'))),
      'coupon_url'        => new sfValidatorUrl(array('max_length' => 255, 'required' => false), array('required' => $lI18n->__('Required'))),
      'coupon_webhook_url' => new sfValidatorUrl(array('max_length' => 255, 'required' => false), array('required' => $lI18n->__('Required'))),
      'coupon_redeem_url' => new sfValidatorUrl(array('max_length' => 255, 'required' => false), array('required' => $lI18n->__('Required')))
    ));

    $this->validatorSchema->setPostValidator(new sfValidatorAnd(
      array(
        new CouponTypeValidator()
    )));
  }

  public function validate_billing(){
    $this->setValidators(array(
    	'payment_method_id' => new sfValidatorString(array('required' => false))
    ));
    //$this->se
  }

  public function validate_verify(){
    $this->setValidators(array(
    	'tos_accepted'      => new sfValidatorBoolean(array('required' => true))
    ));
  }
}
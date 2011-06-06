<?php

/**
 * Deal form.
 *
 * @package    yiid_stats
 * @subpackage form
 * @author     hannes, karina
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class CompleteDealForm extends BaseDealForm
{
  public function configure()
  {
    unset($this['created_at']);
    unset($this['updated_at']);

    if($this->getObject()->isNew()) {
      $coupon = new Coupon();
      $coupon->Deal = $this->getObject();

      $this->setWidget('additional_tos', new sfWidgetFormTextarea());
      $this->setWidget('start_date', new sfWidgetFormInputText());
      $this->setWidget('end_date', new sfWidgetFormInputText());
      $this->setWidget('terms_of_deal', new sfWidgetFormInputText());
      $this->setWidget('redeem_url', new sfWidgetFormInputText());

      $form = new CouponForm($coupon);
      unset($form['deal_id']);
      unset($form['created_at']);
      unset($form['updated_at']);
      unset($this['coupon_claimed_quantity']);
      unset($this['type']);

      $form->setWidget('code', new sfWidgetFormTextarea());


      $this->setDefaults(array(
	    	'start_date' => date('Y-m-d G:i'),
	    	'end_date' => date('Y-m-d G:i'),
        'tos_accepted' => true,
        'deal_state' => 'submitted',
        'coupon_type' => 'html',
      	'read_only' => true
      ));

    /*
    $this->widgetSchema->setLabels(
    	array(
    		'start_date' => _('Start date')
    	)
    );*/
      //'redeem_url'        => new sfValidatorUrl(array('max_length' => 512, 'required' => true, 'trim' => true)),
      $this->validatorSchema['redeem_url'] = new sfValidatorUrl(array('max_length' => 512, 'required' => true, 'trim' => true));
      $this->validatorSchema['terms_of_deal'] = new sfValidatorUrl(array('max_length' => 512, 'required' => true, 'trim' => true));
      $this->validatorSchema['image_url'] = new sfValidatorUrl(array('max_length' => 512, 'required' => true, 'trim' => true));

	    $this->validatorSchema->setPostValidator(new sfValidatorAnd(
	      array(
	        new EndDateValidator(),
	        new OverlappingDealValidator()
	      ))
	    );


      $this->embedForm('Coupon', $form);

    }
  }
}

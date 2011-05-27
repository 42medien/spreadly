<?php

/**
 * Deal form.
 *
 * @package    yiid_stats
 * @subpackage form
 * @author     hannes
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

      $form = new CouponForm($coupon);
      unset($form['deal_id']);
      unset($form['created_at']);
      unset($form['updated_at']);
      $this->embedForm('Coupon', $form);
    
    }
  }
}

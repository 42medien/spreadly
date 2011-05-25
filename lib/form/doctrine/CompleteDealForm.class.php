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
    $couponForm = new CouponForm();
    $this->embedForm('Coupon', $couponForm);
  }
}

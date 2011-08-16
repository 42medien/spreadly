<?php
use_helper('Avatar', 'Text');
?>
<!-- weisser Content -->
<div id="content-inner" class="clearfix deal-content-inner">
  <h3><?php echo __("Thanks for Dealing"); ?></h3>

    <div class="clearfix coupon-<?php echo $deal->getCouponType(); ?>">
      <?php include_partial($deal->getCouponType(), array('deal' => $deal)); ?>
    </div>

</div>
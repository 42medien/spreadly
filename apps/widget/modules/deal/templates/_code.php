<div id="deal_coupon">
  <h3><?php echo $deal->getCouponTitle(); ?></h3>
  <span id="redeemcode"><?php echo $deal->getCouponCode(); ?></span>

  <a class="link B" href="index.html"><?php echo __("Copy to clipboard"); ?></a> <a class="link B" href="<?php echo $deal->getCouponUrl(); ?>"><?php echo __("Visit the shop"); ?></a>
  <p><?php echo $deal->getCouponText(); ?></p>
</div>
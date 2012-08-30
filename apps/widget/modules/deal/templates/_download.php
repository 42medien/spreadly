<div id="deal_url">
  <h3><?php echo $deal->getCouponTitle(); ?></h3>
  <a class="link B" href="<?php echo $deal->getCouponUrl(); ?>" target="_blank"><?php echo __("Download"); ?></a>

  <p><?php echo $deal->getCouponText(); ?></p>
</div>
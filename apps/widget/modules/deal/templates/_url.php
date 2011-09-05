<!-- weisser Content -->
  <div id="deal_url">
    <h3><?php echo $deal->getCouponTitle(); ?></h3>
    <a class="link B" href="<?php echo $deal->getCouponUrl(); ?>"><?php echo __("Go to the reward website"); ?></a>

    <p><?php echo $deal->getCouponText(); ?></p>
  </div>
<?php use_helper('Avatar', 'Text'); ?>
<div id="content-outer" role="main">
<header>
  <h2><?php echo __("Thanks for sharing!"); ?></h2>
  <p id="motivation">
    <span id="deal-marker"><?php echo __('Your deal'); ?></span>
  </p>
</header>

<!-- weisser Content -->
<div id="content-inner" class="clearfix deal-content-inner">
<div id="deal_coupon">
  <h3><?php echo $pDeal->getCouponTitle(); ?></h3>
  <span id="redeemcode"><?php echo $pDeal->getCouponCode(); ?></span>

  <a class="link B" href="#"><?php echo __("Copy to clipboard"); ?></a> <a class="link B" target="_blank" href="<?php echo $pDeal->getCouponUrl(); ?>"><?php echo __("Visit the shop"); ?></a>
  <p><?php echo $pDeal->getCouponText(); ?></p>
</div>
</div>
</div>



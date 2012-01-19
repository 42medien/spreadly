<?php use_helper('Avatar', 'Text'); ?>
<div id="content-outer" role="main">
<header>
  <h1 class="success"><?php echo __("Thanks for sharing!"); ?></h1>
 <span id="deal-marker"><?php echo __("Your deal"); ?></span>
</header>

<!-- weisser Content -->
<div id="content-inner" class="clearfix deal-content-inner">
<div id="deal_coupon">
	<?php //var_dump($pDeal->getCouponCode());die();?>
  <h3><?php echo $pDeal->getCouponTitle(); ?></h3>
  <span id="redeemcode"><?php echo ($pDeal->getCouponType() == 'code')?$pDeal->getCouponCode(): __('IHR CODE'); ?></span>

  <a class="link B" href="#"><?php echo __("Copy to clipboard"); ?></a> <a class="link B" target="_blank" href="<?php echo $pDeal->getCouponUrl(); ?>"><?php echo __("Visit the shop"); ?></a>
  <p><?php echo $pDeal->getCouponText(); ?></p>
</div>
</div>
</div>



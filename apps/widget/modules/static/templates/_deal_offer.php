<?php use_helper("Date"); ?>
<?php if ($pDeal) { ?>
<div class="yellow dashed">
  <div class="coupon-summary"><?php echo $pDeal->getSummary() ?></div>
  <div class="coupon-description">
    <?php echo $pDeal->getDescription() ?>
  </div>
  <div class="coupon-foot"><?php echo __("Expires at"); ?> <span id="deal_end_date-mirror"><?php echo format_date($pDeal->getEndDate()) ?></span>
  <?php
    if (!$pDeal->isUnlimited()) {
      echo "| ".$pDeal->getRemainingCouponQuantity()."/".$pDeal->getCouponQuantity()." ".__("left");
    }
  ?>
  </div>
</div>
<div class="meta-label" id="accept-tod">
	<input type="checkbox" name="coupon-accept-tod" /><?php echo __('I accept the %terms%', array('%terms%' => link_to(__('Terms of Deal'), $pDeal->getTermsOfDeal()))); ?>
</div>
<div id="deal-imprint-url"><?php echo link_to('Imprint', $pDeal->getDomainProfile()->getImprintUrl()); ?></div>
<?php } ?>
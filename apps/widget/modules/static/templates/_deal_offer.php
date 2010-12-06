<?php use_helper("Date"); ?>
<?php if ($pDeal) { ?>
<div class="yellow dashed">
  <div class="coupon-summary deal_summary-mirror"><?php echo $pDeal->getSummary() ?></div>
  <div class="coupon-description deal_description-mirror">
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
<?php } ?>
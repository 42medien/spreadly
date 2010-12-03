<?php use_helper("Date"); ?>
<?php if ($pYiidActivity && $pDeal) { ?>
<div class="content-box yellow dashed">
  <div class="coupon-summary deal_summary-mirror"><?php echo $pDeal->getSummary() ?></div>
  <div class="coupon-description deal_description-mirror">
    <p><?php echo __("Your code"); ?>:</p>
    <p><?php echo $pYiidActivity->getCCode(); ?>
  </div>
  <div class="coupon-foot">
    <p><?php echo __("Be sure to use it until %date. Visit us here:", array("%date" =>format_date($pDeal->getEndDate()))); ?></p>
    <p><?php echo link_to($pDeal->getRedeemUrl(), $pDeal->getRedeemUrl()); ?></p>
  </div>
</div>
<?php } ?>
<?php use_helper("Date"); ?>
<?php if ($pYiidActivity && $lDeal = $pYiidActivity->getDeal()) { ?>
<div class="yellow dashed clearfix" id="deal-info-coupon">
  <div class="coupon-summary deal_summary-mirror"><?php echo $lDeal->getSummary() ?></div>
  <div class="coupon-description deal_description-mirror">
    <p><?php echo __("Your code"); ?>:</p>
    <p><strong><?php echo $pYiidActivity->getCCode(); ?></strong></p>
  </div>
  <div class="coupon-foot">
    <p><?php echo __("Be sure to use it until %date. Visit us here:", array("%date" =>format_date($lDeal->getEndDate()))); ?></p>
    <p><?php echo link_to($lDeal->getRedeemUrl(), $lDeal->getRedeemUrl()); ?></p>
  </div>
</div>
<?php } ?>
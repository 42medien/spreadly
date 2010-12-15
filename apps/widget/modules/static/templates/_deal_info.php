<?php use_helper("Date"); ?>
<?php if ($pYiidActivity && $lDeal = $pYiidActivity->getDeal()) { ?>
<div class="yellow dashed clearfix" id="deal-info-coupon">
  <div class="coupon-summary deal_summary-mirror"><?php echo $lDeal->getSummary() ?></div>
  <div class="coupon-description deal_description-mirror">
    <p><?php echo __("Your Code:"); ?>:</p>
    <p><strong><?php echo $pYiidActivity->getCCode(); ?></strong></p>
  </div>
  <div class="coupon-foot">
    <p><?php echo __("Please go to the following url and redeem your coupon latest until %date%:", array("%date%" =>format_datetime($lDeal->getEndDate()))); ?></p>
    <p><?php echo link_to($lDeal->getRedeemUrl(), $lDeal->getRedeemUrl(), array("target" => "_blank")); ?></p>
  </div>
</div>
<?php } ?>
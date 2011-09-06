<?php use_helper('Text'); ?>
<?php slot('content') ?>

<div id="analytics-bread">
  <ul class="bc-list clearfix">
    <li class="bc-first"></li>
    <li class="bc-gradient"><?php echo link_to(__('Deal Analytics'), 'deal_analytics/index'); ?></li>
    <li class="bc-seperator"></li>
    <li class="bc-gradient"><strong><?php echo __('Overview for "%deal%"', array('%deal%' => truncate_text($pDeal->getName(), 50))); ?></strong></li>
    <li class="bc-last"></li>
  </ul>
</div>
<h2 class="sub_title"><?php echo __('All time overview for deal "%deal%"', array('%deal%' => truncate_text($pDeal->getName(), 50)));?></h2>
<p><?php echo __("There are no stats yet, please come back later."); ?></p>

<?php end_slot(); ?>
<?php include_partial('global/graybox'); ?>
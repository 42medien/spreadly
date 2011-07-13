<?php use_helper('Text', 'YiidUrl', 'YiidNumber'); ?>
<?php slot('headline') ?>
	<h2><?php echo __('Your likes'); ?> <span><?php echo __('List of your likes till yet'); ?></span></h2>
<?php end_slot(); ?>

  <div class="commentlist">
    <?php if ($pActivities) { ?>
    <dl class="clearfix">
      <?php
        foreach ($pActivities as $lActivity) {
          include_partial("likes/like", array("pActivity" => $lActivity));
        }
      ?>
    </dl>
    <?php } else { ?>
      <p><?php echo __("no likes yet"); ?>
    <?php } ?>
  </div>

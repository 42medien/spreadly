<?php include_component('profile', 'profile_info'); ?>

<div class="wht-contentbox clearfix">
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
</div>
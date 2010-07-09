<?php use_helper('Text', 'Avatar'); ?>

<div id="user-line" class="clearfix">
<?php if ($pUser) { ?>
	<?php  echo avatar_tag($pUser->getDefaultAvatar(), 48, array('alt' => 'avatar', 'class' => 'left', 'id' => 'profile_avatar')); ?>
	<h1 class="left light_text">Hi, <?php echo truncate_text($pUser->getFullname(), 20, '...'); ?></h1>
<?php } elseif ($sf_user->hasFlash("username")) { ?>
  <h1 class="left light_text">Hi, <?php echo $sf_user->getFlash("username"); ?></h1>
<?php } else { ?>
  <h1 class="left light_text"><?php echo __('HI_ANONYMOUS', null, 'widget'); ?></h1>
<?php } ?>

<?php if ($pUser) { ?>
  <p class="right light_text"><?php echo __('NOT_YOUR_NAME', array('%1' => truncate_text($pUser->getFullname(), 20, '...'), '%2' => link_to(__('HERE', null, 'widget'), '@signout', array('class' => 'light_text'))), 'widget'); ?></p>
<?php } else { ?>
	<p class="right"><a class="question_link" id="show_help" href="#"><?php echo __('WHY_YIID_ACCOUNT', null, 'widget'); ?></a></p>
<?php } ?>
</div>

<div id="help_area" class="content_main_border rounded_corners light_background" style="display:none;">
  <?php echo __('YIID_BUTTON_DESCRIPTION', null, 'widget'); ?>
</div>
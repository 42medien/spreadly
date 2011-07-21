<?php use_helper('Avatar', 'Text'); ?>
<form action="<?php echo url_for('@save_like'); ?> " name="popup-like-form" id="popup-like-form" method="post">
	<div id="man-url-input-area" class="clearfix">
		<input type="text" id="man-url-input" name="manurl" value="<?php echo __('Insert URL you wanna like'); ?>" />
		<label class="alignright" id="nourl-label"><?php echo __("Please paste the URL you like to spread to your friends."); ?></label>
		<input type="hidden" name="like[ignore_deal]" id="like-ignore-deal" value="1" />
	</div>

	<div id="man-url-content">
	</div>
</form>

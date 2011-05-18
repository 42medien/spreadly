<?php use_helper('Avatar', 'Text'); ?>
<form action="<?php echo url_for('@save_like'); ?> " name="popup-like-form" id="popup-like-form" method="post">
	<?php include_partial('like/like_ois', array('pIdentities' => $pIdentities))?>
	<div class="wht-contentbox clearfix">
		<label class="textfield-wht" id="man-url-label">
			<span>
				<input type="text" id="man-url-input" name="manurl" value="<?php echo __('Insert URL you wanna like'); ?>" />
			</span>
		</label>
		<div id="like-content-box">
		</div>
	</div>
	<input type="hidden" name="like[ignore_deal]" id="like-ignore-deal" value="1" />
</form>
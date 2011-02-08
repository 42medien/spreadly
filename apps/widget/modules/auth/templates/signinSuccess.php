<div class="whtboxtop">
	<div class="rcor">
		<h1 class="deal-title"><?php echo __('Signup with one of the following services'); ?></h1>
	</div>
</div>
<div class="wht-contentbox clearfix">
		<div class="whtboxpad">
		  <ul id="logos_big" class="normal_list small_size important clearfix">
		    <li id="facebook_area"><a id="facebook_logo" class="service_icon" href="<?php echo url_for("@signinto?service=facebook", true); ?>">Facebook</a></li>
		    <li id="twitter_area"><a id="twitter_logo" class="service_icon" href="<?php echo url_for("@signinto?service=twitter", true); ?>">Twitter</a></li>
		    <li id="linkedin_area"><a id="linkedin_logo" class="service_icon" href="<?php echo url_for("@signinto?service=linkedin", true); ?>">Linkedin</a></li>
		    <li id="google_area"><a id="google_logo" class="service_icon" href="<?php echo url_for("@signinto?service=google", true); ?>">Google Buzz</a></li>
		  </ul>
			<p id="yiid_help_text" class="dark_text small_size">
			  <?php echo __('YIID_IT_HELPTEXT', null, 'widget'); ?>
			</p>
			<p id="cancel_action"><a href="#2" id="cancel-link"><?php echo __('CANCEL', null, 'widget'); ?></a></p>
		</div>
</div>
<div class="whtboxbot"><span></span></div>
<iframe src="http://widgets.<?php echo sfConfig::get("app_settings_host"); ?>/w/like/like.php?visible=false&url=dummy" border="none" width="0px" height="0px" style="border:none;width:0px;height:0px;"></iframe>
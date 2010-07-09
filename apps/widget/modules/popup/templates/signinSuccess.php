<div id="normal_box" class="content_main_border rounded_corners clearfix">

  <ul id="logos_big" class="normal_list small_size important clearfix">
    <li><a id="facebook_logo" class="service_icon" href="<?php echo RpxClient::generateApiUrl("facebook", url_for("@confirm_signin", true)); ?>">Facebook</a></li>
    <li id="twitter_area"><a id="twitter_logo" class="service_icon" href="<?php echo RpxClient::generateApiUrl("twitter", url_for("@confirm_signin", true)); ?>">Twitter</a></li>
    <li id="further_logos">&nbsp;</li>
  </ul>

</div>

<p id="yiid_help_text" class="dark_text small_size">
  <?php echo __('YIID_IT_HELPTEXT', null, 'widget'); ?>

</p>

<p id="cancel_action"><a href="#2" id="cancel-link"><?php echo __('CANCEL', null, 'widget'); ?></a></p>

<iframe src="http://widgets.<?php echo sfConfig::get("app_settings_host"); ?>/w/like/like.php?visible=false" border="none" width="0px" height="0px" style="border:none;width:0px;height:0px;"></iframe>
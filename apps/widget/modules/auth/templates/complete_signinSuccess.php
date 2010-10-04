<div id="normal_box" class="content_main_border rounded_corners clearfix">

  <div id="welcome_text">
    <?php echo __('YIID_BUTTON_FIRST_TIME', null, 'widget'); ?>
  </div>

  <div id="agb_text">
	  <h1><?php echo $sf_data->getRaw('headline'); ?></h1>
	  <p><?php echo $sf_data->getRaw('text'); ?></p>
  </div>

  <form method="post" action="<?php echo url_for("popup/create_account"); ?>">
    <input type="hidden" name="agb" value="1" />
    <input type="submit" id="agree_tos" class="btn rounded_corners content_main_border right" value="<?php echo __('I_AGREE', null, 'widget'); ?>" />
  </form>
</div>

<div id="login_box" class="content_main_border rounded_corners clearfix">

  <div class="left">
    <?php echo __('YIID_BUTTON_RECURRING', null, 'widget'); ?>
  </div>

  <div class="right">
    <ul id="logos_small" class="normal_list">
      <li><a id="facebook_logo_small" href="<?php //echo RpxClient::generateApiUrl("facebook", url_for("@confirm_signin?do=signin", true)); ?>">Facebook</a></li>
      <li><a id="twitter_logo_small" href="<?php //echo RpxClient::generateApiUrl("twitter", url_for("@confirm_signin?do=signin", true)); ?>">Twitter</a></li>
    </ul>
  </div>

</div>

<div id="cancel_action" class="clearfix">
  <a href="#1" id="cancel-link"><?php echo __('CANCEL', null, 'widget'); ?></a>
</div>
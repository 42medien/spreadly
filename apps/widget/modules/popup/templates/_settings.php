<?php use_helper('Text'); ?>
<div class="clearfix">
	<div id="twocol_left" class="content_main_border rounded_corners light_background left">
    <h3><?php echo __('YOUR_NETWORKS', null, 'widget'); ?></h3>
	  <form action="<?php echo (url_for("popup/settings")); ?>" method="post">

      <ul class="normal_list" id="services_chosen">
      <?php foreach ($pIdentities as $lIdentity) { ?>
        <li id="check_<?php echo $lIdentity->getCommunity()->getCommunity(); ?>">
          <input type="checkbox" id="enabled_services[<?php echo $lIdentity->getId(); ?>]"
            name="enabled_services[<?php echo $lIdentity->getId(); ?>]" <?php echo $lIdentity->getSocialPublishingEnabled()?"checked=checked":''; ?>
            value="<?php echo $lIdentity->getId(); ?>" />
          <label for="<?php echo $lIdentity->getCommunity()->getCommunity(); ?>_check" title="<?php echo $lIdentity->getProfileUri(); ?>">
            <?php echo truncate_text($lIdentity->getProfileUri(), 25, '...'); ?>
          </label>
        </li>
      <?php } ?>
      </ul>

      <input type="submit" class="btn rounded_corners content_main_border" value="<?php echo __('SAVE', null, 'widget'); ?>" />
	  </form>
	</div>

	<div id="twocol_right_add" class="content_main_border rounded_corners light_background right" >
    <h3><?php echo __('ADD_FURTHER_NETWORKS', null, 'widget'); ?></h3>
    <p><?php echo __('CURRENT_NETWORKS', null, 'widget'); ?></p>

    <ul class="normal_list" id="services_to_choose">
      <li><a id="choose_facebook" href="<?php echo url_for("@popup_signinto?service=facebook", true); ?>">Facebook</a></li>
      <li><a id="choose_twitter" href="<?php echo url_for("@popup_signinto?service=twitter", true); ?>">Twitter</a></li>
      <li><a id="choose_linkedin" href="<?php echo url_for("@popup_signinto?service=linkedin", true); ?>">Linkedin</a></li>
      <li><a id="choose_google" href="<?php echo url_for("@popup_signinto?service=google", true); ?>">Google Buzz</a></li>
    </ul>

    oder <a href="#"  id="cancel-link"><?php echo __('CANCEL', null, 'widget'); ?></a>

	</div>


	<div id="twocol_right_empty" class="content_main_border rounded_corners light_background right" style="display: none;">
    <?php echo __('NO_FURTHER_NETWORKS', array('%1' => mail_to('neu@yiid.it')), 'widget'); ?>
  </div>

</div>

<div id="see_friends_actions" class="clearfix">
  <a href="http://www.yiid.com" target="_blank"><?php echo __('YOUR_FRIENDS_LIKES', null, 'widget'); ?></a>
</div>

<iframe src="http://widgets.<?php echo sfConfig::get("app_settings_host"); ?>/w/like/like.php?visible=false&url=dummy" border="none" width="0px" height="0px" style="border:none;width:0px;height:0px;"></iframe>
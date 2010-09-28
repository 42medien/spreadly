<div id="signin_area" class="single_box_with_shadow">
  <div id="signin_via_services" <?php if ($pAuthType != "delegated") { echo 'style="display: none;"'; } ?>>
	  <h3><?php echo __('No registration needed - please use your favourite service to login'); ?></h3>
	  <p>
      <?php echo __('(For returning users: please use the same service you have used before or login with user and password %1)',
        array('%1' => '<a href="/" class="toggle_login_area" data-obj=\'{"from_id":"signin_via_username", "to_id":"signin_via_services"}\'>'.__('HERE', null, 'widget').'</a>')); ?>
	  </p>

	  <ul class="service_icons_big normal_list clearfix">
	    <li class="left icon_big icon_big_facebook">
		    <?php echo link_to("Facebook", "@auth_signin?service=facebook"); ?>
	    </li>
	    <li class="left icon_big icon_big_twitter">
	      <?php echo link_to("Twitter", "@auth_signin?service=twitter"); ?>
	    </li>
	  </ul>

	  <p>
	  <?php
      echo __('If you have not used the Yiid button before, we will automatically create an account for you on Yiid.com, where you can manage your services, see your and your friends "Likes" and much more.');
      echo __('By using Yiid you agree to the %1 of Yiid.', array('%1' => link_to(__('Terms and Conditions'), '@tos')));
      echo __('If you are a recurring user, simply choose a service that you have used before - we will know you and enable your former settings.');
    ?>
    </p>
	</div>

	<div id="signin_via_username" <?php if ($pAuthType != "basic") { echo 'style="display: none;"'; } ?>>
    <h3><?php echo __('Returning user? Log in here.'); ?></h3>
    <p><?php echo __('(First time users please go back %1.)', array('%1' => '<a href="/" class="toggle_login_area" data-obj=\'{"from_id":"signin_via_services", "to_id":"signin_via_username"}\'>'.__('HERE', null, 'widget').'</a>')); ?></p>

    <form action="<?php echo url_for('@auth_basic'); ?>" method="post" id="signin_via_username_form">

      <?php if ($pError) { ?>
	      <p class="error"><?php echo $pError; ?></p>
	    <?php } ?>

      <div class="center_area clearfix">
		    <label for="signin_user" class="left"><?php echo __("USERNAME"); ?></label>
			  <input name="signin_user" type="text" id="signin_user" />
			</div>

		  <div class="center_area clearfix">
			  <label for="signin_password" class="left"><?php echo __("PASSWORD"); ?></label>
		    <input name="signin_password" type="password" id="signin_password" />
		  </div>

      <div class="center_area">
        <label for="login" class="left">&nbsp;</label>
        <input type="submit" value="<?php echo __("LOGIN"); ?>" class="btn" />
      </div>

   </form>

   <p><?php echo __('Password forgotten? Then simply login with a service you have used before ... %1.',
   array('%1' => link_to(__('HERE', null, 'widget'), '/'))); ?></p>
	</div>
</div>

<div class="center_area clearfix">
  <h2><?php echo __('What is Yiid?'); ?></h2>
</div>

<div id="what_is_yiid_description" class="clearfix">
  <div class="description_with_image left">
    <p><?php echo __('Find cool new articles, products or people on the web and use the Yiid button to share what you have found with your friends.'); ?></p>
    <div id="yiid_description1" class="center_area">
      <iframe src="http://widgets.<?php echo sfConfig::get("app_settings_host"); ?>/w/like/like.php?<?php echo 'url=http%3A%2F%2Fwww.yiid.com&cult='.$sf_user->getCulture().'&type=like&color=%23000000&short='; ?>"
        style="overflow:hidden; width: 295px; height: 23px; padding: 3px 0;" frameborder="0" scrolling="no" marginheight="0" allowTransparency="true"></iframe>
    </div>
  </div>

  <div class="description_wave left"></div>

  <div class="description_with_image left">
    <p><?php echo __('Share to Facebook, Twitter and many more of your profiles simultanously with just one click.'); ?></p>
    <div id="yiid_description2" class="center_area"></div>
  </div>

  <div class="description_wave left"></div>

  <div class="description_with_image left">
    <p><?php echo __('See all your friends shares on Facebook, Twitter and many other networks combined in your personal dashboard.'); ?></p>
    <div id="yiid_description3" class="center_area"></div>
  </div>
</div>
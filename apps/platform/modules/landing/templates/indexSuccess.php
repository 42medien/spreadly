<div id="signin_area">
  <div id="signin_via_services" <?php if ($pAuthType != "delegated") { echo 'style="display: none;"'; } ?>>
	  <h3><?php echo __('No registration needed - please use your favourite service to login', null, "platform"); ?></h3>
	  <p>
      <?php echo __('(For returning users: please use the same service you have used before or login with user and password %1.)', 
        array('%1' => '<a href="/" onclick="Utils.toggleTwoAreas(\'signin_via_username\', \'signin_via_services\');return false;">here</a>'), "platform"); ?>
	  </p>

	  <ul class="service_icons_big normal_list clearfix">
	    <li class="left icon_big icon_big_facebook">
		    <?php echo link_to("Facebook", "@auth_signin?service=facebook"); ?>
	    </li>
	    <li class="left icon_big icon_big_twitter">
	      <?php echo link_to("Twitter", "@auth_signin?service=twitter"); ?>
	    </li>
	    <li class="left icon_big icon_big_google">
	      <a href="/">Google</a>
	    </li>
	  </ul>

	  <p><?php echo __('If you have not used the Yiid button before, we will automatically create an account for you on Yiid.com, where you can manage your services,
	  see your and your friends "Likes" and much more. By using Yiid you agree to the %1 of Yiid.
	  If you are a recurring user, simply choose a service that you have used before - we will know you and enable your former settings.', array('%1' => '<a href="/">Terms and Conditions</a>'), "platform"); ?></p>
	</div>

	<div id="signin_via_username" <?php if ($pAuthType != "basic") { echo 'style="display: none;"'; } ?>>
    <h3><?php echo __('Returning user? Log in here.', null, "platform"); ?></h3>
    <p><?php echo __('(First time users please go back %1.)', array('%1' => '<a href="/" onclick="Utils.toggleTwoAreas(\'signin_via_services\', \'signin_via_username\');return false;">here</a>'), "platform"); ?></p>

    <form action="<?php echo url_for('auth/basic'); ?>" method="post" id="signin_via_username_form">
    
      <?php if ($pError) { ?>
	      <p class="error"><?php echo $pError; ?></p>
	    <?php } ?>

      <div class="center_area clearfix">
		    <label for="signin_user" class="left"><?php echo __("USERNAME", null, "platform"); ?></label>
			  <input name="signin_user" type="text" id="signin_user" />
			</div>

		  <div class="center_area clearfix">
			  <label for="signin_password" class="left"><?php echo __("PASSWORD", null, "platform"); ?></label>
		    <input name="signin_password" type="password" id="signin_password" />
		  </div>

      <div class="center_area">
        <label for="login" class="left">&nbsp;</label>
        <input type="submit" value="<?php echo __("LOGIN", null, "platform"); ?>" class="btn" />
      </div>

   </form>

   <p><?php echo __('Password forgotten? Then simply login with a service you have used before ... %1.', 
   array('%1' => '<a href="/" onclick="Utils.toggleTwoAreas(\'signin_via_services\', \'signin_via_username\');return false;">here</a>'), 'platform'); ?></p>
	</div>
</div>

<div class="center_area clearfix">
  <h2><?php echo __('What is Yiid?', null, 'platform'); ?></h2>
</div>

<div id="what_is_yiid_description" class="clearfix">
  <div class="description_with_image left">
    <p><?php echo __('Find cool new articles, products or people on the web and use the Yiid button to share what you have found with your friends.', null, 'platform'); ?></p>
    <div id="yiid_description1" class="center_area image_button_full_long_en"></div>
  </div>

  <div class="description_wave left"></div>

  <div class="description_with_image left">
    <p><?php echo __('Share to Facebook, Twitter and many more of your profiles simultanously with just one click.', null, 'platform'); ?></p>
    <div id="yiid_description2" class="center_area"></div>
  </div>

  <div class="description_wave left"></div>

  <div class="description_with_image left">
    <p><?php echo __('See all your friends shares on Facebook, Twitter and many other networks combined in your personal dashboard.', null, 'platform'); ?></p>
    <div id="yiid_description3" class="center_area"></div>
  </div>
</div>
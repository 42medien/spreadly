<div id="signin_area">
  <div id="signin_via_services">
	  <h3>No registration needed - please use your favourite service to login</h3>
	  <p>
      (For returning users: please use the same service you've used before or login with user and password
      <a href="/" onclick="Utils.toggleTwoAreas('signin_via_username', 'signin_via_services');return false;">here</a>.)
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

	  <p>If you haven't used the Yiid button before, we will automatically create an account for you on Yiid.com, where you can manage your services,
	  see your and your friends "Likes" and much more. By using Yiid you agree to the <a href="/">Terms and Conditions</a> of Yiid.
	  If you're a recurring user, simply choose a service that you've used before - we will know you and enable your former settings.</p>
	</div>

	<div id="signin_via_username" style="display: none;">
    <h3>Returning user? Log in here.</h3>
    <p>
      (First time users please go back
      <a href="/" onclick="Utils.toggleTwoAreas('signin_via_services', 'signin_via_username');return false;">here</a>.)
    </p>

    <form action="<?php echo url_for('auth/basic'); ?>" method="post" id="signin_via_username_form">

      <div class="center_area clearfix">
		    <label for="signin_user" class="left">User</label>
			  <input name="signin_user" type="text" id="signin_user" />
			</div>

		  <div class="center_area clearfix">
			  <label for="signin_password" class="left">Password</label>
		    <input name="signin_password" type="password" id="signin_password" />
		  </div>

      <div class="center_area">
        <label for="login" class="left">&nbsp;</label>
        <input type="submit" value="login" class="btn" />
      </div>

   </form>

   <p>Password forgotten? Then simply login with a service you've used before ... <a href="/" onclick="Utils.toggleTwoAreas('signin_via_services', 'signin_via_username');return false;">here</a>.</p>
	</div>
</div>

<div class="center_area clearfix">
  <h2>What is Yiid?</h2>
</div>

<div id="what_is_yiid_description" class="clearfix">
  <div class="description_with_image left">
    <p>Find cool new articles, products or people on the web and use the Yiid button to share what you've found with your friends.</p>
    <div id="yiid_description1" class="center_area"></div>
  </div>

  <div class="description_wave left"></div>

  <div class="description_with_image left">
    <p>Share to Facebook, Twitter and many more of your profiles simultanously with just one click.</p>
    <div id="yiid_description2" class="center_area"></div>
  </div>

  <div class="description_wave left"></div>

  <div class="description_with_image left">
    <p>See all your friends shares on Facebook, Twitter and many other networks combined in your personal dashboard.</p>
    <div id="yiid_description3" class="center_area"></div>
  </div>
</div>
<div id="get_code_area">
  <div class="one_third left area_border" id="signin_area">
    <div class="clearfix">
	    <form action="auth/signin" method="POST">
	      <h4><?php echo __('Login'); ?></h4>
	      <div class="clearfix">
	        <input type="text" name="user[email]" value="<?php echo __('Email'); ?>" />
	      </div>
	      <div class="clearfix">
	        <input type="password" name="user[password]" value="<?php echo __('Password'); ?>" />
	      </div>
	      <div id="button_get_code_outer" class="clearfix">
		      <input type="submit" id="button-likebutton" class="submit-button" value="<?php echo __('Login'); ?>">
		    </div>
	    </form>
    
	    <div class="normal_button">
	      <?php echo link_to(__('or register &raquo;'), '/'); ?>
	    </div>
    </div>
  </div>
  <div class="two_third left area_border" id="analytics_description_area">
    <div class="clearfix">
	    <h4><?php echo __('Get free analytics with your registration'); ?></h4>
	    <h3><?php echo __('Get the perfect view on'); ?></h3>
	    <ul class="clearfix">
	      <li><?php echo __('where your users come from'); ?></li>
	      <li><?php echo __('what services they use'); ?></li>
	      <li><?php echo __('what demographics they have (age, gender etc.)'); ?></li>
	      <li><?php echo __('what language they speak'); ?></li>
	      <li><?php echo __('new and recurring users'); ?></li>
	    </ul>
	    <div class="normal_button">
	      <?php echo link_to(__('No thanks, just the code please'), '/'); ?>
	    </div>
	  </div>
  </div>
</div>
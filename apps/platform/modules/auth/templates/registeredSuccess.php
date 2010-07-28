<div id="signin_area">
  <div id="signin_via_services">
    <h3><?php echo __('Thanks, you\'ve successfully registered!', null, "platform"); ?></h3>
    <p>
      <?php echo __('Please add more accounts to enable sharing to more sites simultanously.', null, 'platform'); ?>
    </p>

    <div class="two_block_area clearfix" id="services_after_registration">
      <div class="left_block left">
        <h5><?php echo __('Services you\'ve enabled:'); ?></h5>
	      <ul class="services_enabled normal_list">
	        <li>
            <span class="icon_small_service icon_small_facebook left">&nbsp;</span>
            <?php echo __('your %1 %2 account', array('%1' => 'Facebook', '%2' => link_to('Thomas Huhn', 'http://www.facebook.com/thuhn')), 'platform'); ?>
          </li>
	      </ul>
	    </div>
	    <div class="right_block right">
        <h5><?php echo __('Add more services:'); ?></h5>
	      <ul class="services_disabled normal_list">
	        <li>
            <span class="icon_big_twitter_add_service icon_big_add_service left">&nbsp;</span>
            <?php echo __('Add your %1 account', array('%1' => link_to('Twitter', 'http://www.twitter.com')), 'platform'); ?>
          </li>
	        <li>
            <span class="icon_big_google_add_service icon_big_add_service left">&nbsp;</span>
            <?php echo __('Add your %1 account', array('%1' => link_to('Google Buzz', 'http://www.google.com')), 'platform'); ?>
          </li>
	      </ul>
	    </div>
    </div>
    
    <div class="center_area clearfix">
      <?php echo link_to(__('Skip', null, 'platform'), '@homepage'); ?>
    </div>
  </div>
</div>
<div id="signin_area" class="single_box_with_shadow">
  <div id="signin_via_services">
    <h3><?php echo __("Thanks, you've successfully registered!"); ?></h3>
    <p>
      <?php echo __('Please add more accounts to enable sharing to more sites simultanously.'); ?>
    </p>

    <div class="two_block_area clearfix" id="services_after_registration">
      <div class="left_block left">
        <h5><?php echo __("Services you've enabled:"); ?></h5>
	      <ul class="services_enabled normal_list">
	        <?php foreach ($pOnlineIdenities as $lOi) { ?>
	        <li>
            <span class="icon_small_service icon_small_<?php echo $lOi->getCommunity()->getCommunity(); ?> left">&nbsp;</span>
            <?php echo __('your %1 %2 account', array('%1' => $lOi->getCommunity()->getName(), '%2' => link_to($lOi->getName(), $lOi->getUrl(), array('target' => '_blank')))); ?>
          </li>
          <?php } ?>
	      </ul>
	    </div>
	    <div class="right_block right">
        <h5><?php echo __('Add more services'); ?>:</h5>
	      <ul class="services_disabled normal_list">
	        <li>
            <span class="icon_big_twitter_add_service icon_big_add_service left">&nbsp;</span>
            <?php echo __('Add your %1 account', array('%1' => link_to('Twitter', '@auth_signin?service=twitter'))); ?>
          </li>
	        <li>
            <span class="icon_big_facebook_add_service icon_big_add_service left">&nbsp;</span>
            <?php echo __('Add your %1 account', array('%1' => link_to('Facebook', '@auth_signin?service=facebook'))); ?>
          </li>
	      </ul>
	    </div>
    </div>

    <div class="center_area clearfix">
      <?php echo link_to(__('Skip'), '@stream'); ?>
    </div>
  </div>
</div>
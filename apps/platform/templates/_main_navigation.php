<div id="nav_main_area" class="right clearfix">
	<div id="nav_main_supp" class="clearfix">
    <?php if($sf_user->isAuthenticated()) { ?>
	    <div class="right">
	      <?php echo link_to(__('Logout'), '@auth_signout', array('class' => 'url')); ?>
	    </div>
    <?php } ?>
    <?php $lAction = $sf_params->get('action'); ?>
    <?php if($lAction != 'imprint' && $lAction != 'tos') { ?>
		  <div class="right" id="language_switch_area">
		    <?php include_component('system', 'language_switch_icons'); ?>
		  </div>
		<?php } ?>
	</div>
	<ul id="nav_main" class="right clearfix">
    <?php if($sf_user->isAuthenticated()) { ?>
      <li><?php echo link_to(__('Home'), '@homepage', array('id' => 'nav_home')); ?></li>
      <li id="nav_main_settings"><?php echo link_to(__('Settings'), '@auth_add_services', array('id' => 'nav_settings')); ?></li>
    <?php } else { ?>
      <li><?php echo link_to(__('Start'), '@homepage', array('id' => 'nav_home')); ?></li>
    <?php } ?>
	</ul>
</div>
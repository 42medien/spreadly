<div id="nav_main_area" class="right clearfix">
	<div id="nav_main_supp" class="clearfix">
    <div class="right">
      <?php echo link_to(__('Logout'), '@auth_signout', array('class' => 'url')); ?>
    </div>
    <div class="right" id="language_switch_area">
      <?php include_component('system', 'language_switch_icons'); ?>
    </div>
	</div>
	<ul id="nav_main" class="clearfix">
	  <li><?php echo link_to(__('Home'), '@homepage', array('id' => 'nav_home')); ?></li>
	  <li><?php echo link_to(__('Profile'), '@homepage', array('id' => 'nav_profile')); ?></li>
	  <li id="nav_main_settings"><?php echo link_to(__('Settings'), '@auth_add_services', array('id' => 'nav_settings')); ?></li>
	</ul>
</div>
<div style="height: 60px;" class="right clearfix">
	<div style="height: 20px;text-align: right;padding: 5px 28px 0 0;" class="clearfix">
    <div class="right">
      <?php echo link_to(__('Logout'), '@auth_signout', array('class' => 'url')); ?>
    </div>
    <div class="right" style="margin-right: 20px;">
      <?php include_component('system', 'language_switch_icons'); ?>
    </div>
	</div>
	<ul id="nav_main" class="clearfix" style="height: 25px;">
	  <li><?php echo link_to(__('Home'), '@homepage', array('id' => 'nav_home')); ?></li>
	  <li><?php echo link_to(__('Profile'), '@homepage', array('id' => 'nav_profile')); ?></li>
	  <li id="nav_main_settings"><?php echo link_to(__('Settings'), '@homepage', array('id' => 'nav_settings')); ?></li>
	</ul>
</div>
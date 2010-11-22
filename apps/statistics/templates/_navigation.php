<div id="nav_main" class="clearfix">
  <div id="nav_wave_left"></div>
  <div id="nav_wave_middle"></div>
  <div id="nav_wave_right" class="left">
    <?php if($sf_user->isAuthenticated()): ?>
    <span class="navigation_text">
      <?php echo __('Hello').' '.$sf_user->getUsername(); ?> |
    </span>
    <span class="navigation_text">
      <?php echo link_to(__('Dashboard'), '@dashboard'); ?> |
    </span>
    <span class="navigation_text">
      <?php echo link_to(__('Build Button'), '@configurator'); ?> |
    </span>
    <span class="navigation_text">
      <?php echo link_to(__('Deals'), 'deals/index'); ?> |
    </span>
    <span class="navigation_text">
      <?php echo link_to(__('Domains'), 'domain_profiles/index'); ?> |
    </span>
    <span class="navigation_text">
      <?php echo link_to(__('Analytics'), '@analytics'); ?> |
    </span>
    <span class="navigation_text">
      <?php echo link_to(__('Logout'), '@sf_guard_signout'); ?>
    </span>
    <?php endif; ?>

    <?php include_component('auth', 'login_box'); ?>
  </div>
</div>
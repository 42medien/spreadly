<div id="nav_main" class="clearfix">
  <div id="nav_wave_left"></div>
  <div id="nav_wave_middle"></div>
  <div id="nav_wave_right" class="left">
    <?php if($sf_user->isAuthenticated()): ?>
      <span class="navigation_text">
        <?php echo __('Hello').' '.$sf_user->getUsername(); ?> |
      </span>
      <span class="navigation_text">
        <?php echo link_to('Users', url_for('sf_guard_user')) ?> |
      </span>
      <span class="navigation_text">
        <?php echo link_to('OldStats', url_for('@oldstats')) ?> |
      </span>
      <span class="navigation_text">
        <?php echo link_to('Permissions', url_for('sf_guard_permission')) ?> |
      </span>
      <span class="navigation_text">
        <?php echo link_to('Deals', url_for('deal')) ?> |
      </span>
      <span class="navigation_text">
        <?php echo link_to(__('Logout'), '@sf_guard_signout'); ?>
      </span>
    <?php endif; ?>

  </div>
</div>
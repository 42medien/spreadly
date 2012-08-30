<div id="nav_main_area" class="right clearfix">
  <div id="nav_main_supp" class="clearfix">
    <div class="right">
    </div>
    <div class="right" id="language_switch_area">
    </div>
  </div>
  <ul id="nav_main" class="clearfix">
    <?php if($sf_user->isAuthenticated()): ?>
      <li><?php echo $sf_user->getUsername() ?> | <?php echo link_to(__('Logout'), url_for('sf_guard_signout')) ?></li>
      <li><?php echo link_to('Users', url_for('sf_guard_user')) ?></li>
      <li><?php echo link_to('OldStats', url_for('@oldstats')) ?></li>
      <?php /* <li><?php echo link_to('Groups', url_for('sf_guard_group')) ?></li> */ ?>
      <li><?php echo link_to('Permissions', url_for('sf_guard_permission')) ?></li>
    <?php else: ?>
      <li><?php echo link_to('Signin', url_for('sf_guard_signin')) ?></li>
    <?php endif; ?>
  </ul>
</div>

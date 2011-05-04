<div id="nav_main" class="clearfix">
  <div id="nav_wave_left">
    <a href="/backend.php"><img src="/img/backend_logo.png" alt="Spreadly" /></a>
  </div>
  <div id="nav_wave_middle"></div>
  <div id="nav_wave_right" class="left">
    <?php if($sf_user->isAuthenticated()): ?>
      <?php $module = $sf_context->getModuleName(); ?>
      <span class="navigation_text">
        <?php echo __('Hello').' '.$sf_user->getUsername(); ?> |
      </span>
      <span class="navigation_text <?php if($module=='deal') { echo 'active'; } ?>">
        <?php echo link_to('Deals', url_for('deal', array("sort" => "updated_at", "sort_type" => "desc"))) ?> |
      </span>
      <span class="navigation_text <?php if($module=='sfGuardUser') { echo 'active'; } ?>">
        <?php echo link_to('Users', url_for('sf_guard_user')) ?> |
      </span>
      <span class="navigation_text <?php if($module=='domain') { echo 'active'; } ?>">
        <?php echo link_to('Domains', url_for('domain/index')) ?> |
      </span>
      <span class="navigation_text <?php if($module=='oldstats') { echo 'active'; } ?>">
        <?php echo link_to('OldStats', url_for('@oldstats')) ?> |
      </span>
      <span class="navigation_text <?php if($module=='job') { echo 'active'; } ?>">
        <?php echo link_to('Jobs', url_for('job/index')) ?> |
      </span>
      <span class="navigation_text">
        <?php echo link_to(__('Logout'), '@sf_guard_signout'); ?>
      </span>
    <?php endif; ?>

  </div>
</div>

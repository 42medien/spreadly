<?php slot('content') ?>
  <div class="languagebox alignright">
  	<?php if($sf_user->isAuthenticated()): ?>
  	  <?php echo link_to(__('Logout'), '@sf_guard_signout', array("class" => "alignleft logout")); ?>
  	<?php endif; ?>
    <a href="<?php echo url_for('@update_language?lang=en'); ?>" class="alignleft"><img src="/img/uk-flag-icon.png" width="25" height="26" alt="UK" title="UK" /></a>
    <a href="<?php echo url_for('@update_language?lang=de'); ?>" class="alignleft"><img src="/img/germany-flag.png" width="25" height="26" alt="Deutsch" title="Deutsch" /></a>
  </div>

  <ul id="topnavigation" class="alignleft">
    <?php $module = $sf_context->getModuleName(); ?>
    <?php $action = $sf_context->getActionName(); ?>

    <!-- li><a href="<?php echo url_for('@dashboard'); ?>" title="Dashboard" <?php if($module=='likebutton' && $action=='dashboard') { echo 'class="active"';} ?>><span><?php echo __('Dashboard'); ?></span></a></li-->
    <?php if ($sf_user->isAuthenticated()) { ?>
      <li><div class="welcome_user"><?php echo __('Hello').' '.$sf_user->getUsername(); ?></div></li>
      <li><a href="<?php echo url_for('@analytics_overview'); ?>" title="Analytics" <?php if($module=='analytics' && ($action=='index' || $action=='statistics')) { echo 'class="active"';} ?>><span><?php echo __('Analytics'); ?></span></a></li>
      <li><a href="<?php echo url_for('@deals'); ?>" title="Deals"<?php if($module=='deals') { echo 'class="active"';} ?>><span><?php echo __('Deals'); ?></span></a></li>
      <li><a href="<?php echo url_for('domain_profiles/index'); ?>" title="Domains" <?php if($module=='domain_profiles') { echo 'class="active"';} ?>><span><?php echo __('Domains'); ?></span></a></li>
    <?php } ?>
    <li class="last"><a href="<?php echo url_for('@configurator'); ?>" title="Buttons" <?php if($module=='likebutton' && $action=='index') { echo 'class="active"';} ?>><span><?php echo __('Buttons'); ?></span></a></li>
  </ul>
<?php end_slot(); ?>
<?php include_partial('global/graybox'); ?>
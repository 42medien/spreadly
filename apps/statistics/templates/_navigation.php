<?php slot('content') ?>
  <div class="languagebox alignright">
  	<?php if($sf_user->isAuthenticated()): ?>
  	  <div class="welcome_user alignleft"><?php echo __('Hello').' '.$sf_user->getUsername(); ?></div>
  	  <?php echo link_to(__('Logout'), '@sf_guard_signout', array("class" => "alignleft logout")); ?>
  	<?php else: ?>
  	  <?php echo link_to(__('Login'), '@sf_guard_signin', array("class" => "colorbox")); ?>
      <?php echo __('or'); ?> <?php echo link_to(__('Register'), '@sf_guard_register', array("class" => "colorbox")); ?>
  	<?php endif; ?>
    <a href="<?php echo url_for('@update_language?lang=en'); ?>" class="alignright"><img src="/img/uk-flag-icon.png" width="25" height="26" alt="UK" title="UK" /></a>
    <a href="<?php echo url_for('@update_language?lang=de'); ?>" class="alignright"><img src="/img/germany-flag.png" width="25" height="26" alt="Deutsch" title="Deutsch" /></a>
  </div>

  <ul id="topnavigation" class="alignleft">
    <?php $module = $sf_context->getModuleName(); ?>
    <?php $action = $sf_context->getActionName(); ?>


    <li><a href="<?php echo url_for('landing/index'); ?>" title="Landing" <?php if($module=='landing' && $action=='index') { echo 'class="active"';} ?>><span><?php echo __('Home'); ?></span></a></li>
    <li><a href="<?php echo url_for('@configurator'); ?>" title="Buttons" <?php if($module=='configurator' && $action=='index') { echo 'class="active"';} ?>><span><?php echo __('Buttons'); ?></span></a></li>
    <!-- li><a href="<?php echo url_for('@dashboard'); ?>" title="Dashboard" <?php if($module=='likebutton' && $action=='dashboard') { echo 'class="active"';} ?>><span><?php echo __('Dashboard'); ?></span></a></li-->
    <li><a href="<?php echo url_for('@analytics_overview'); ?>" title="Analytics" <?php if($module=='analytics' && ($action=='index' || $action=='statistics')) { echo 'class="active"';} ?>><span><?php echo __('Analytics'); ?></span></a></li>
    <li><a href="<?php echo url_for('@deals'); ?>" title="Deals"<?php if($module=='deals') { echo 'class="active"';} ?>><span><?php echo __('Deals'); ?></span></a></li>
    <li class="last"><a href="<?php echo url_for('domain_profiles/index'); ?>" title="Domains" <?php if($module=='domain_profiles') { echo 'class="active"';} ?>><span><?php echo __('Domains'); ?></span></a></li>
  </ul>
<?php end_slot(); ?>
<?php include_partial('global/graybox'); ?>
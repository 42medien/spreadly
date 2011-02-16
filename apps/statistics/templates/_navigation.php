<?php slot('content') ?>
  <div class="languagebox alignright">
  	<?php if($sf_user->isAuthenticated()): ?>
  	  <?php echo link_to(__('Logout'), '@sf_guard_signout', array("class" => "alignleft logout")); ?>
  	<?php endif; ?>
    <a href="<?php echo url_for('@update_language?lang=en'); ?>" class="alignleft"><img src="/img/uk-flag-icon.png" width="25" height="26" alt="UK" title="UK" /></a>
    <a href="<?php echo url_for('@update_language?lang=de'); ?>" class="alignleft"><img src="/img/germany-flag.png" width="25" height="26" alt="Deutsch" title="Deutsch" /></a>
  </div>
  
  <ul id="topnavigation" class="alignleft">
  	<?php if($sf_user->isAuthenticated()): ?>
  		<li><a href="#" class="welcome_user"><?php echo __('Hello').' '.$sf_user->getUsername(); ?></a></li>
      <li><a href="<?php echo url_for('@dashboard'); ?>" title="Dashboard" <?php if($sf_context->getModuleName()=='likebutton' && $sf_context->getActionName()=='dashboard') { echo 'class="active"';} ?>><span><?php echo __('Dashboard'); ?></span></a></li>
      <li><a href="<?php echo url_for('@configurator'); ?>" title="Buttons" <?php if($sf_context->getModuleName()=='likebutton' && $sf_context->getActionName()=='index') { echo 'class="active"';} ?>><span><?php echo __('Buttons'); ?></span></a></li>
      <li><a href="<?php echo url_for('domain_profiles/index'); ?>" title="Domains" <?php if($sf_context->getModuleName()=='domain_profiles') { echo 'class="active"';} ?>><span><?php echo __('Domains'); ?></span></a></li>
      <li><a href="<?php echo url_for('@analytics_overview'); ?>" title="Analytics" <?php if($sf_context->getModuleName()=='analytics' && ($sf_context->getActionName()=='index' || $sf_context->getActionName()=='statistics')) { echo 'class="active"';} ?>><span><?php echo __('Analytics'); ?></span></a></li>
      <li class="last"><a href="<?php echo url_for('@deals'); ?>" title="Deals"<?php if($sf_context->getModuleName()=='deals') { echo 'class="active"';} ?>><span><?php echo __('Deals'); ?></span></a></li>
    <?php endif; ?>
  </ul>
  
  <?php include_component('auth', 'login_box'); ?>
<?php end_slot(); ?>
<?php include_partial('global/graybox'); ?>
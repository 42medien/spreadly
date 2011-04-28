<?php slot('content') ?>
  <div class="languagebox alignright">
  	<?php $lCult = $sf_user->getCulture(); ?>
    <a href="<?php echo url_for('@update_language?lang=en'); ?>" class="alignright"><img src="/img/uk-flag-icon.png" width="25" height="26" alt="UK" title="UK" <?php echo ($lCult == 'de')? 'class="inactive-cult"':""; ?> /></a>
    <a href="<?php echo url_for('@update_language?lang=de'); ?>" class="alignright"><img src="/img/germany-flag.png" width="25" height="26" alt="Deutsch" title="Deutsch" <?php echo ($lCult == 'en')? 'class="inactive-cult"':""; ?>  /></a>
  	<?php if($sf_user->isAuthenticated()){ ?>
  		<div class="alignright">
	  	  <div class="welcome_user alignleft">
	  	    <?php echo __('Hello').' '.$sf_user->getUsername(); ?>
	  	  </div>
	  	  <?php echo link_to(__('Logout'), '@sf_guard_signout', array("class" => "alignleft logout")); ?>
  	  </div>
  	<?php } ?>
  	<?php if(!$sf_user->isAuthenticated()) {?>
  		<div class="login-links alignright">
	  	  <?php echo link_to(__('Login'), '@sf_guard_signin', array("class" => "colorbox")); ?>
	      <?php echo __('or'); ?> <?php echo link_to(__('Register'), '@sf_guard_register', array("class" => "colorbox")); ?>
	   </div>
  	<?php } ?>
  </div>

  <ul id="topnavigation" class="alignleft">
    <?php $module = $sf_context->getModuleName(); ?>
    <?php $action = $sf_context->getActionName(); ?>
  	<?php
  		$lColorbox = '';
  		if(!$sf_user->isAuthenticated()) {
  			$lColorbox = "colorbox";
  		}
  	?>

    <li>
    	<a href="<?php echo url_for('landing/index'); ?>" title="Landing" <?php if($module=='landing' && $action=='index') { echo 'class="active"';} ?>>
    		<span><?php echo __('Home'); ?></span>
    	</a>
    </li>
    <li>
    	<a href="<?php echo url_for('@configurator'); ?>" title="Buttons" <?php if($module=='configurator' && $action=='index') { echo 'class="active"';} ?>>
    		<span><?php echo __('Buttons'); ?></span>
    	</a>
    </li>
    <li>
    	<a href="<?php echo url_for('@analytics_overview'); ?>" title="Analytics" class="<?php if($module=='analytics') { echo "active";} echo $lColorbox; ?>">
    		<span><?php echo __('Analytics'); ?></span>
    	</a>
    </li>
    <li>
    	<a href="<?php echo url_for('@deals'); ?>" title="Deals" class="<?php if($module=='deals') { echo "active";} echo $lColorbox; ?>">
    		<span><?php echo __('Deals'); ?></span>
    	</a>
    </li>
    <li class="<?php if(!$sf_user->isSuperAdmin()) { echo 'last'; } ?>">
    	<a href="<?php echo url_for('domain_profiles/index'); ?>" title="Domains" class="<?php if($module=='domain_profiles') { echo "active";} echo $lColorbox; ?>">
    		<span><?php echo __('Domains'); ?></span>
    	</a>
    </li>

    <?php if($sf_user->isSuperAdmin()) { ?>
      <li class="last">
      	<a href="/backend.php" title="Backend">
      		<span>Backend</span>
      	</a>
      </li>
    <?php } ?>
  </ul>
<?php end_slot(); ?>
<?php include_partial('global/graybox'); ?>
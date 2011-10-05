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

  <ul id="topnavigation" class="clearfix">
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
      <a href="<?php echo url_for('@configurator'); ?>" title="Buttons" <?php if(($module=='configurator' && $action=='index')) { echo 'class="active"';} ?>>
        <span><?php echo __('Button'); ?></span>
      </a>
    </li>
    <li>
    	<a href="<?php echo url_for('@configurator'); ?>" title="Buttons" <?php if($module=='domain_profiles' || $module=='analytics') { echo 'class="active"';} ?>>
    		<span><?php echo __('Publisher'); ?></span>
    	</a>
    </li>
    <li>
    	<a href="<?php echo url_for('@advertiser'); ?>" title="Advertiser Overview" class="<?php if($module=='deals' || $module=='deal_analytics' || $module=='advertiser') { echo "active";} ?>">
    		<span><?php echo __('Advertiser'); ?></span>
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

  <?php if($module=='configurator' || $module=='domain_profiles' || $module=='analytics') { ?>
	  <ul id="subnavigation">
	    <li>
	    	<a href="<?php echo url_for('@configurator'); ?>" title="Buttons" <?php if($module=='configurator' && $action=='index') { echo 'class="active"';} ?>>
	    		<?php echo __('Get Button'); ?>
	    	</a>
	    </li>
	    <li>
	    	<a href="<?php echo url_for('domain_profiles/index'); ?>" title="Domains" class="<?php if($module=='domain_profiles') { echo "active";} echo $lColorbox; ?>">
	    		<?php echo __('Register domain'); ?>
	    	</a>
	    </li>
	    <li>
	    	<a href="<?php echo url_for('@analytics_overview'); ?>" title="Analytics" class="<?php if($module=='analytics' || $module=='deal_analytics') { echo "active";} echo $lColorbox; ?>">
	    		<?php echo __('Get analytics'); ?>
	    	</a>
	    </li>
	  </ul>
	 <?php } ?>

  <?php if($module=='deals' || $module=='deal_analytics' || $module=='advertiser') { ?>
	  <ul id="subnavigation">
	    <li>
	    	<a href="<?php echo url_for('@deals'); ?>" title="Deals" class="<?php if($module=='deals') { echo "active";} echo $lColorbox; ?>">
	    		<?php echo __('Create deal'); ?>
	    	</a>
	    </li>
	    <li>
	    	<a href="<?php echo url_for('deal_analytics/index'); ?>" title="Deal analytics" class="<?php if($module=='deal_analytics') { echo "active";} echo $lColorbox; ?>">
	    		<?php echo __('Get analytics'); ?>
	    	</a>
	    </li>
	    <li>
	    	<a href="<?php echo url_for('advertiser/apply_api'); ?>" title="Deal API" class="<?php if($module=='advertiser' && $action != "index") { echo "active";} echo $lColorbox; ?>">
	    		<?php echo __('Deal API'); ?>
	    	</a>
	    </li>
	  </ul>
	 <?php } ?>

<?php end_slot(); ?>
<?php include_partial('global/graybox'); ?>
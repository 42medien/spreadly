    <?php $module = $sf_context->getModuleName(); ?>
    <?php $action = $sf_context->getActionName(); ?>

			<div id="header">
				<div class="container_12">
					<h1 id="logo" class="alignleft"><a href="<?php echo url_for('landing/index');?>" title="Spreadly">Spreadly</a></h1>
					<nav class="clearfix alignright grid_6">
						<ul class="header-link clearfix alignright">
							<li class="blog"><a href="http://blog.spreadly.com/" target="_blank" title="<?php echo __('Blog'); ?>"><?php echo __('Blog'); ?></a></li>
							<li class="about"><a href="<?php echo url_for('@customer'); ?>" title="<?php echo __('Über uns'); ?>"><?php echo __('Über uns'); ?></a></li>
  						<?php if(!$sf_user->isAuthenticated()) {?>
								<li class="sign"><a href="<?php echo url_for('@sf_guard_signin'); ?>" title="<?php echo __('Login'); ?>"><?php echo __('Login'); ?></a></li>
  						<?php } else { ?>
								<li class="sign"><a href="<?php echo url_for('@sf_guard_signout'); ?>" title="<?php echo __('Logout'); ?>"><?php echo __('Logout'); ?></a></li>
							<?php } ?>
							<li class="call"><?php echo __('Telefon: +49 6201 845 200'); ?></li>
						</ul>
					</nav>
					<nav class="clearfix  grid_10 alignright">
						<ul id="mainNavigation" class="clearfix alignright">
							<li><a href="<?php echo url_for('landing/index'); ?>" <?php if($module=='landing' && $action=='index') { echo 'class="active"';} ?> title="<?php echo __('Home'); ?>"><?php echo __('Home'); ?></a></li>
							<li><a href="<?php echo url_for('@configurator'); ?>" <?php if(($module=='configurator' && $action=='index')) { echo 'class="active"';} ?> title="<?php echo __('Button');?>"><?php echo __('Buttons');?></a></li>
							<li>
								<a href="<?php echo url_for('@publisher'); ?>" <?php if($module=='domain_profiles' || $module=='analytics' || $module=='publisher') { echo 'class="active"';} ?> title="<?php echo __('Publisher'); ?>"><?php echo __('Webseitenbetreiber'); ?></a>

								<?php if($module=='domain_profiles' || $module=='analytics' || $module=='publisher') { ?>
									<ul class="second-level-nav clearfix">
										<li class="first"></li>
										<li><a href="<?php echo url_for('@configurator'); ?>"><?php echo __('Button'); ?></a></li>
										<li><a href="<?php echo url_for('@domain_profiles'); ?>"><?php echo __('Domain registrieren'); ?></a></li>
										<li class="last"><a href="<?php echo url_for('@analytics_overview'); ?>"><?php echo __('Statistiken'); ?></a></li>
									</ul>
								<?php } ?>
							</li>

							<li>
								<a href="<?php echo url_for('@advertiser'); ?>" <?php if($module=='deals' || $module=='deal_analytics' || $module=='advertiser') { echo 'class="active"';} ?> title="<?php echo __('Advertiser'); ?>"><?php echo __('Werbetreibende'); ?></a>
									<?php if($module=='deals' || $module=='deal_analytics' || $module=='advertiser') { ?>
									<ul class="second-level-nav clearfix">
										<li class="first"></li>
										<li><a href="<?php echo url_for('@deals'); ?>"><?php echo __('Kampagne starten'); ?></a></li>
										<li><a href="<?php echo url_for('@deal_analytics_index'); ?>"><?php echo __('Statistiken'); ?></a></li>
										<li class="last"><a href="<?php echo url_for('@dealapi'); ?>"><?php echo __('Deal API'); ?></a></li>
									</ul>
									<?php } ?>
							</li>


							<li <?php echo ($sf_user->isAuthenticated() && !$sf_user->isSuperAdmin())?'class="last"':''?>><a href="<?php echo url_for('@pricing'); ?>" <?php if(($module=='landing' && $action=='pricing')) { echo 'class="active"';} ?> title="<?php echo __('Pricing');?>"><?php echo __('Preise');?></a></li>
					    <?php if($sf_user->isSuperAdmin()) { ?>
					      <li class="last">
					      	<a href="/backend.php" title="Backend">
										<?php echo __('Backend'); ?>
					      	</a>
					      </li>
					    <?php } ?>
  						<?php if(!$sf_user->isAuthenticated()) {?>
  							<li class="last"><a href="<?php echo url_for('@sf_guard_register'); ?>" title="Registrieren"><?php echo __('Registrieren'); ?></a></li>
  						<?php } ?>
						</ul>
					</nav>
				</div>
			</div>
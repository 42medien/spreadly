<html>
<head>
	<title><?php echo __('Spread.ly - We monetize Social Sharing'); ?></title>
	<?php include_metas() ?>
	<?php include_http_metas() ?>

	<meta property="og:site_name" content="Spread.ly" />
	<meta property="og:image" content="<?php echo image_path("/img/spreadlyicon.jpg", true); ?>" />
	<meta property="og:url" content="http://spreadly.com" />
	<meta property="og:type" content="website" />
	<meta property="og:email" content="info@spreadly.com" />
	<meta property="og:phone_number" content="+49-6201-845200" />
	<meta name="google-site-verification" content="0nH-7N_-Vix-3dGyWtqvJUn9IESoCtdi9wLN_Wp5MQs" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />


	<link href="/css/new_styles.css" rel="stylesheet" type="text/css">
	<link href="/css/grid.css" rel="stylesheet" type="text/css">
	<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
	<link rel="stylesheet" type="text/css" href="/css/colorbox/colorbox.css" media="screen" />
	<!--[if IE]>
	<link href="/css/new_ie.css" rel="stylesheet" type="text/css">
	<![endif]-->
	<!--[if IE 6]>
	<script src="/js/DD_belatedPNG.js"></script>
	<script>
	  DD_belatedPNG.fix('*');
	</script>
	<![endif]-->
	<script type="text/javascript" src="/js/100_main/include/statistics-<?php echo sfConfig::get('app_release_name') ?>.min.js"></script>
    <script type="text/javascript" src="/js/statistics/configurator/SchemePicker.js"></script>

	<?php include_javascripts();?>
    <?php $module = $sf_context->getModuleName(); ?>
    <?php $action = $sf_context->getActionName(); ?>
</head>
<body>
<div id="wrapper_outer">
	<div class="wrapperspace">
		<div class="main-container">
			<header>
			<div id="header">
				<div class="container_12">
					<h1 id="logo" class="alignleft"><a href="<?php echo url_for('landing/index');?>" title="Spread.ly">Spread.ly</a></h1>
					<nav class="clearfix alignright grid_6">
						<ul class="header-link clearfix alignright">
							<li class="blog"><a href="http://blog.spreadly.com/" target="_blank" title="<?php echo __('Blog'); ?>"><?php echo __('Blog'); ?></a></li>
							<li class="about"><a href="http://ekaabo.de/" target="_blank" title="<?php echo __('About Us'); ?>"><?php echo __('About Us'); ?></a></li>
  						<?php if(!$sf_user->isAuthenticated()) {?>
								<li class="sign"><a href="<?php echo url_for('@sf_guard_signin'); ?>" title="<?php echo __('Sign In'); ?>"><?php echo __('Sign In'); ?></a></li>
  						<?php } else { ?>
								<li class="sign"><a href="<?php echo url_for('@sf_guard_signout'); ?>" title="<?php echo __('Logout'); ?>"><?php echo __('Logout'); ?></a></li>
							<?php } ?>
							<li class="call"><?php echo __('Call Us: +49 6201 845 200'); ?></li>
						</ul>
					</nav>
					<nav class="clearfix  grid_8 alignright">
						<ul id="mainNavigation" class="clearfix alignright">
							<li><a href="<?php echo url_for('landing/index'); ?>" <?php if($module=='landing' && $action=='index') { echo 'class="active"';} ?> title="<?php echo __('Home'); ?>"><?php echo __('Home'); ?></a></li>
							<li><a href="<?php echo url_for('@configurator'); ?>" <?php if(($module=='configurator' && $action=='index')) { echo 'class="active"';} ?> title="<?php echo __('Button');?>"><?php echo __('Button');?></a></li>
							<li><a href="<?php echo url_for('@publisher'); ?>" <?php if($module=='domain_profiles' || $module=='analytics' || $module=='publisher') { echo 'class="active"';} ?> title="<?php echo __('Publisher'); ?>"><?php echo __('Publisher'); ?></a></li>
							<li <?php echo ($sf_user->isAuthenticated() && !$sf_user->isSuperAdmin())?'class="last"':''?>><a href="<?php echo url_for('@advertiser'); ?>" <?php if($module=='deals' || $module=='deal_analytics' || $module=='advertiser') { echo 'class="active"';} ?> title="<?php echo __('Advertiser'); ?>"><?php echo __('Advertiser'); ?></a></li>
					    <?php if($sf_user->isSuperAdmin()) { ?>
					      <li class="last">
					      	<a href="/backend.php" title="Backend">
										<?php echo __('Backend'); ?>
					      	</a>
					      </li>
					    <?php } ?>
  						<?php if(!$sf_user->isAuthenticated()) {?>
  							<li class="last"><a href="<?php echo url_for('@sf_guard_register'); ?>" title="Sign Up"><?php echo __('Sign Up'); ?></a></li>
  						<?php } ?>
						</ul>
					</nav>
				</div>
			</div>
		</header>

		<?php if($module !='landing'){ ?>
		<section class="content-publish">
			<section class="container_12">
						<?php echo $sf_content; ?>
			</section>
		</section>
		<?php }?>




	  <?php /*if(has_component_slot('site_bottom')) {?>
    	<?php include_component_slot('site_bottom'); ?>
    <?php } else { ?>
    	<?php include_partial('global/bottom'); ?>
    <?php }*/ ?>




		<section class="learn-moreTab">
			<section class="container_12"><span>Benefit from four times greater range</span><a href="#" title="Learn More">Learn More</a></section>
		</section>
		</div>
	</div>
	<div id="wrapper_footer">
			<footer id="footer" class="clearfix">
				<div class="container_12">
					<div class="clearfix">
						<ul class="footer-links clearfix">
							<li class="first"><?php echo __('Site Map'); ?></li>
							<li><a href="<?php echo url_for('landing/index'); ?>" title="Home"><?php echo __('Home');?></a></li>
							<li><a href="<?php echo url_for('@configurator'); ?>" title="Buttons"><?php echo __('Button');?></a></li>
							<li><a href="<?php echo url_for('@publisher'); ?>" title="Publisher"><?php echo __('Publisher'); ?></a></li>
							<li><a href="<?php echo url_for('@advertiser'); ?>" title="Advertiser"><?php echo __('Advertiser'); ?></a></li>
						</ul>
						<ul class="footer-links clearfix">
							<li class="first"><?php echo __('Support'); ?></li>
							<li><?php echo link_to(__('GetSatisfaction'), 'http://getsatisfaction.com/spreadly', array('target' => '_blank')); ?></li>
							<li><?php echo link_to(__('Help via Twitter'), 'http://twitter.com/spreadly_helps', array('target' => '_blank')); ?></li>
							<li><a href="mailto:info@spreadly.com"><?php echo __('Help via Email'); ?></a></li>
						</ul>
						<ul class="footer-links clearfix services-link">
							<li class="first"><?php echo __('Services'); ?></li>
							<li><?php echo link_to(__('Chrome Extension'), 'https://chrome.google.com/extensions/detail/leclmjclggfnkhdpkgnagcdnhnomapda', array('target' => '_blank')); ?></li>
							<li><?php echo link_to(__('Other Extensions'), 'http://code.google.com/p/spreadly/wiki/Plugins', array('target' => '_blank')); ?></li>
							<li><?php echo link_to(__('Wordpress Plugin'), 'http://wordpress.org/extend/plugins/yiidit/', array('target' => '_blank')); ?></li>
							<li><?php echo link_to(__('Developer-Wiki'), 'http://code.google.com/p/spreadly/', array('target' => '_blank')); ?></li>
							<li><?php echo link_to(__('Developer-Documentation'), 'http://code.google.com/p/spreadly/wiki/developerdocumentation', array('target' => '_blank')); ?></li>
							<li><?php echo link_to(__('PuSH-Api'), 'http://code.google.com/p/spreadly/wiki/PuSH_API', array('target' => '_blank')); ?></li>
						</ul>
						<ul class="footer-links clearfix com-link">
							<li class="first"><?php echo __('Company'); ?></li>
							<li><?php echo link_to(__('Our Blog'), 'http://blog.spreadly.com/', array('target' => '_blank')); ?></li>
							<li><?php echo link_to(__('About ekaabo'), 'http://ekaabo.de/', array('target' => '_blank')); ?></li>
							<li><?php echo link_to(__('TOS'), 'system/tos'); ?></li>
							<li><?php echo link_to(__('Privacy'), 'system/privacy'); ?></li>
							<li><?php echo link_to(__('Imprint'), '@imprint'); ?></li>
						</ul>
						<ul class="footer-links clearfix last">
							<li class="first"><?php echo __('Contact'); ?></li>
							<li><a href="mailto:info@spreadly.com"><?php echo __('Send email'); ?></a></li>
							<li><?php echo link_to(__('Spread.ly @ Facebook'), 'http://www.facebook.com/spreadly', array('target' => '_blank')); ?></li>
							<li><?php echo link_to(__('Spread.ly @ Twitter'), 'http://twitter.com/spreadly', array('target' => '_blank')); ?></li>
						</ul>
					</div>
					<p class="copyright"><?php echo __('&copy; Copyright 2011 ekaabo GmbH. All rights reserved.'); ?></p>
				</div>
			</footer>
		</div>
</div>

	<script type="text/javascript">
    jQuery(document).ready( function() {
      <?php include_partial('global/js_init_general.js'); ?>
      <?php if (has_slot('js_document_ready')) { ?>
        <?php include_slot('js_document_ready'); ?>
      <?php } ?>
    });
	</script>

</body>
</html>

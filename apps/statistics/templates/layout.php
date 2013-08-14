<!DOCTYPE html>
<html>
<head>
	<title><?php echo __('Spreadly - We monetize Social Sharing'); ?></title>
	<?php include_metas() ?>
	<?php include_http_metas() ?>

	<meta property="og:site_name" content="Spreadly" />
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
	<link rel="stylesheet" type="text/css" href="/css/vendor/colorpicker.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="/css/font-awesome.css" media="screen" />


	<link rel="stylesheet" type="text/css" href="/css/coupon.css" media="screen" />
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
  
	<?php include_javascripts();?>
  <?php $module = $sf_context->getModuleName(); ?>
  <?php $action = $sf_context->getActionName(); ?>
</head>
<body>
<div id="wrapper_outer">
	<div class="wrapperspace">
		<div class="main-container">
			<header>
				<?php include_partial('global/navigation'); ?>
		</header>

		<?php if($module !='landing'){ ?>
			<?php if($module == 'deals') { ?>
				<section class="content-btnpage">
					<section class="container_12">
			<?php } else {  ?>
				<section class="content-publish">
					<section class="container_12 clearfix">
			<?php } ?>
		<?php } ?>
						<?php echo $sf_content; ?>
		<?php if($module !='landing'){ ?>
			</section>
		</section>
		<?php }?>

	  <?php if(has_component_slot('site_bottom')) {?>
    	<?php include_component_slot('site_bottom'); ?>
    <?php } else { ?>
    	<?php include_partial('global/bottom'); ?>
    <?php } ?>




		<section class="learn-moreTab">
			<section class="container_12"><span><?php echo __('Profitieren Sie von der großen Reichweite Ihrer Besucher'); ?></span><a href="<?php echo url_for('@customer');?>" title="<?php echo __('Mehr Infos'); ?>"><?php echo __('Mehr Infos'); ?></a></section>
		</section>
		</div>
	</div>
	<div id="wrapper_footer">
			<footer id="footer" class="clearfix">
				<div class="container_12">
					<div class="clearfix">
						<ul class="footer-links clearfix">
							<li class="first"><?php echo __('Sitemap'); ?></li>
							<li><a href="<?php echo url_for('landing/index'); ?>" title="<?php echo __('Home');?>"><?php echo __('Home');?></a></li>
							<li><a href="<?php echo url_for('@configurator'); ?>" title="<?php echo __('Button');?>"><?php echo __('Button');?></a></li>
							<li><a href="<?php echo url_for('@publisher'); ?>" title="<?php echo __('Webseitenbetreiber'); ?>"><?php echo __('Webseitenbetreiber'); ?></a></li>
							<li><a href="<?php echo url_for('@advertiser'); ?>" title="<?php echo __('Werbetreibende'); ?>"><?php echo __('Werbetreibende'); ?></a></li>
						</ul>
						<ul class="footer-links clearfix">
							<li class="first"><?php echo __('Support'); ?></li>
							<li><?php echo link_to(__('GetSatisfaction'), 'http://getsatisfaction.com/spreadly', array('target' => '_blank')); ?></li>
							<li><?php echo link_to(__('Help via Twitter'), 'http://twitter.com/spreadly_helps', array('target' => '_blank')); ?></li>
							<li><a href="mailto:info@spreadly.com"><?php echo __('Hilfe per Email'); ?></a></li>
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
							<li><?php echo link_to(__('Spreadly @ Facebook'), 'http://www.facebook.com/spreadly', array('target' => '_blank')); ?></li>
							<li><?php echo link_to(__('Spreadly @ Twitter'), 'http://twitter.com/spreadly', array('target' => '_blank')); ?></li>
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

    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', 'UA-24814204-1']);
    _gaq.push(['_setDomainName', 'spreadly.com']);
    _gaq.push(['_setAllowHash', 'false']);
    _gaq.push(['_trackPageview']);

    (function() {
      var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
      ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
      var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
    })();
	</script>
	<img id="general-ajax-loader" style="display:none;" src="/img/global/ajax-loader-bar-circle.gif" />
  
  <script type="text/javascript">
  var fb_param = {};
  fb_param.pixel_id = '6007617555408';
  fb_param.value = '0.00';
  fb_param.currency = 'EUR';
  (function(){
    var fpw = document.createElement('script');
    fpw.async = true;
    fpw.src = '//connect.facebook.net/en_US/fp.js';
    var ref = document.getElementsByTagName('script')[0];
    ref.parentNode.insertBefore(fpw, ref);
  })();
  </script>
  <noscript><img height="1" width="1" alt="" style="display:none" src="https://www.facebook.com/offsite_event.php?id=6007617555408&amp;value=0&amp;currency=EUR" /></noscript>
</body>
</html>
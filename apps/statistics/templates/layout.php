<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <?php include_title() ?>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />


    <link rel="stylesheet" type="text/css" href="/js/100_main/vendor/jquery_ui_datepicker/timepicker_plug/css/style.css" />
    <link rel="stylesheet" type="text/css" href="/js/100_main/vendor/jquery_ui_datepicker/smothness/jquery_ui_datepicker.css" />
		<link rel="stylesheet" type="text/css" href="/css/styles.css" media="screen" />
		<link rel="stylesheet" type="text/css" href="/css/yiid-styles.css" media="screen" />
		<link rel="stylesheet" type="text/css" href="/css/print.css" media="print" />

		<!--[if IE]>
		<link rel="stylesheet" type="text/css" href="/css/ie.css" />
		<![endif]-->
		<!--[if IE 6]>
		<script src="/js/DD_belatedPNG.js"> </script>
		<script>
		  DD_belatedPNG.fix('*');
		</script>
		<![endif]-->
		<?php if ($sf_params->get('resize') == true) { ?>
		<script>
      window.resizeTo(580,500);
    </script>
    <?php } ?>
    <script type="text/javascript" src="/js/100_main/include/statistics-<?php echo sfConfig::get('app_release_name') ?>.js"></script>
    <script type="text/javascript" src="/js/statistics/deals/DealHandler.js"></script>
    <?php include_javascripts();?>
    <link rel="shortcut icon" href="/img/favicon.ico" />
  </head>
<body class="innerpage">
	<div id="wrapper">
		<!--feedback box start-->
		<div class="feedback"><a href="#"><img src="/img/feedback.png" alt="Feedback" title="Feedback" width="155" height="137" /></a></div>
    <!--feedback box end-->
    <div id="header">
    	<div class="clearfix">
      	<div id="logo-spread" class="alignleft"><img src="/img/spread-logo-domain.png" width="306" height="128" alt="" /></div>
        <span class="alignleft easy-tagline"><img src="/img/easy-tagline.png" width="237" height="63" alt="It's as easy as cut, copy and paste" title="It's as easy as cut, copy and paste" /></span></div>
			</div>
			<!--Content start here -->
			<div id="content" class="clearfix">
      	<!--Top Navigation box start -->
        <div class="topnavblock">
        	<div class="grboxtop"><span></span></div>
          <div class="grboxmid">
          	<div class="grboxmid-content">
            	<div class="graybox clearfix">
              	<div class="languagebox alignright">
              		<a href="<?php url_for('@sf_guard_signout'); ?>" class="alignleft logout"><?php echo __('Logout'); ?></a>  <a href="<?php echo url_for('@update_language?lang=en'); ?>" class="alignleft"><img src="/img/uk-flag-icon.png" width="25" height="26" alt="UK" title="UK" /></a><a href="<?php echo url_for('@update_language?lang=de'); ?>" class="alignleft"><img src="/img/germany-flag.png" width="25" height="26" alt="Deutsch" title="Deutsch" /></a>
								</div>
								<ul id="topnavigation" class="alignleft">
    							<?php if($sf_user->isAuthenticated()){ ?>
                		<li><a href="#" class="welcome_user"><?php echo __('Hello').' '.$sf_user->getUsername(); ?></a></li>
                  <?php } ?>
                  <li><a href="<?php echo url_for('@dashboard'); ?>" title="Dashboard" <?php if($sf_context->getModuleName()=='likebutton' && $sf_context->getActionName()=='dashboard') { echo 'class="active"';} ?>><span><?php echo __('Dashboard'); ?></span></a></li>
                  <li><a href="<?php echo url_for('@configurator'); ?>" title="Buttons" <?php if($sf_context->getModuleName()=='likebutton' && $sf_context->getActionName()=='index') { echo 'class="active"';} ?>><span><?php echo __('Buttons'); ?></span></a></li>
                  <li><a href="<?php echo url_for('domain_profiles/index'); ?>" title="Domains" <?php if($sf_context->getModuleName()=='domain_profiles') { echo 'class="active"';} ?>><span><?php echo __('Domains'); ?></span></a></li>
                  <li><a href="<?php echo url_for('@analytics_overview'); ?>" title="Analytics" <?php if($sf_context->getModuleName()=='analytics' && ($sf_context->getActionName()=='index' || $sf_context->getActionName()=='statistics')) { echo 'class="active"';} ?>><span><?php echo __('Analytics'); ?></span></a></li>
                  <li class="last"><a href="<?php echo url_for('@deals'); ?>" title="Deals"<?php if($sf_context->getModuleName()=='deals') { echo 'class="active"';} ?>><span><?php echo __('Deals'); ?></span></a></li>
                </ul>
            	</div>
            </div>
          </div>
          <div class="grboxbot"><span></span></div>
				</div>
        <!--Top Navigation box end -->
        <?php echo $sf_content; ?>
  		</div>

      <!--Content end here -->
			<div id="footer" class="nobg">
   			<span>Copyright Yidd 2010</span>  |  <a href="#" title="Imprint">Imprint</a> |  <a href="#" title="TOS">TOS</a> |   <a href="#" title="Privacy Policy">Privacy Policy</a> |   <a href="mailto:info@yiid.com ">info@yiid.com </a></div>
			</div>
		<script type="text/javascript">
			// Custom Checkbox Function
	    jQuery(document).ready( function() {
	      <?php include_partial('global/js_init_general.js'); ?>
	      <?php if (has_slot('js_document_ready')) { ?>
	        <?php include_slot('js_document_ready'); ?>
	      <?php } ?>
	    });
		</script>
		<img id="general-ajax-loader" style="display:none;" src="/img/global/ajax-loader-bar-circle.gif" />
	</body>
</html>
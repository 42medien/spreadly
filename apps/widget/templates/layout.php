<?php use_helper('YiidUrl', 'Avatar', 'Text') ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <title><?php echo __('Spread.ly - first choice for social sharing'); ?></title>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />


		<link rel="stylesheet" type="text/css" href="/css/popup.css" media="screen" />
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
      window.resizeTo(580,600);
    </script>
    <?php } ?>
    <script type="text/javascript">var _sf_startpt=(new Date()).getTime()</script>
    <script type="text/javascript" src="/js/100_main/include/widget-<?php echo sfConfig::get('app_release_name') ?>.js"></script>
    <script type="text/javascript" src="/js/widget/like/LikeHandler.js"></script>


    <link rel="shortcut icon" href="/favicon.ico" />
  </head>
  <body class="nobg">
  	<div class="popupblock">
  		<header>
				<nav class="clearfix">
		      <!--Pop Navigation start -->
		      <?php if ($sf_user->isAuthenticated() ) { ?>
		          <ul class="nav-list alignright" role="navigation">
		            <li><span><?php echo __('Hi'); ?> <?php echo truncate_text($sf_user->getUser()->getUsername(), 10); ?></span></li>
		            <li><?php echo link_to(__('Logout'), '@signout'); ?></li>
		          </ul>
		          <ul class="nav-list" role="navigation">
		            <li <?php if ($sf_context->getModuleName()=='likes') { echo 'class="active"'; } ?>><?php echo link_to(__('Likes'), '@widget_likes'); ?></li>
		            <li <?php if ($sf_context->getModuleName()=='deals') { echo 'class="active"'; } ?>><?php echo link_to(__('Deals'), '@widget_deals'); ?></li>
		            <li id="nav-next-to-last" class="<?php if ($sf_context->getModuleName()=='settings') { echo 'active'; } ?>"><?php echo link_to(__('Settings'), '@widget_settings'); ?></li>
								<li id="nav-spread" class="<?php if ($sf_context->getModuleName()=='like') { echo ''; } ?>"><?php echo link_to(__('Like it!'), '@widget_like'); ?></li>
		          </ul>
		      <?php } ?>
		      <!-- Pop Navigation end -->
				</nav>
			</header>
			<div id="content-outer" role="main">
				<header>
					<h2>Überschrift <span>Explain the stuff</span></h2>
				</header>
				<div id="content-inner">
					<?php echo $sf_content; ?>
				</div>
			</div>

			<footer class="clearfix">
				<ul>
					<li><?php echo link_to(__("Imprint"), "http://spreadly.com/imprint", array("target" => "_blank")); ?></li>
					<li><?php echo link_to("Powered by Spreadly", sfConfig::get("app_settings_url"), array("title" => "spread.ly", "target" => "_blank")) ?></li>
				</ul>
			</footer>
		</div>
    <!--popup block end -->
		<img id="general-ajax-loader" style="display:none;" src="/img/global/ajax-loader-bar-circle.gif" />
	  <script  type="text/javascript">
	    jQuery(document).ready( function() {
	      <?php
	        if (has_slot('js_document_ready')) {
	          include_slot('js_document_ready');
	        }
	      ?>
	    });

      var _sf_async_config={uid:23222,domain:"spread.ly"};
      (function(){
        function loadChartbeat() {
          window._sf_endpt=(new Date()).getTime();
          var e = document.createElement('script');
          e.setAttribute('language', 'javascript');
          e.setAttribute('type', 'text/javascript');
          e.setAttribute('src',
             (("https:" == document.location.protocol) ? "https://a248.e.akamai.net/chartbeat.download.akamai.com/102508/" : "http://static.chartbeat.com/") +
             "js/chartbeat.js");
          document.body.appendChild(e);
        }
        var oldonload = window.onload;
        window.onload = (typeof window.onload != 'function') ?
           loadChartbeat : function() { oldonload(); loadChartbeat(); };
      })();
	  </script>
  </body>
</html>

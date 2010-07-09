<?php use_helper('YiidUrl') ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <title><?php echo __('OPEN_DISLIKE'); ?></title>
    <link rel="shortcut icon" href="/favicon.ico" />
    <link rel="stylesheet" type="text/css" media="screen" href="/css/globalunlike.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="/css/colorpicker.css" />

    <script type="text/javascript" src="/js/vendor/jquery-complete.min.js"></script>
    <script type="text/javascript" src="/js/vendor/colorpicker.js"></script>
    <script type='text/javascript' src='/js/vendor/GlobalUnlike.js'></script>

    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">

  </head>
  <body>
		<div id="header" class="clearfix">
		  <div id="header-wrapper">
		    <div id="header-content" class="clearfix">
		      <div id="logo" class="left header-box">
            <h1><?php echo link_to(__('OPEN_DISLIKE'), '@opendislike_stream'); ?><span class="info">[beta]</span></h1>
          </div>
          <div class="left" id="becomes">BECOMES &raquo;</div>
          <div id="yiid-it-logo" class="left">
            <a href="http://www.yiid.it"><img src="/img/yiid-it-logo.png"/></a>
          </div>
          <div id="header-text" class="right">
             <span> Because of the great feedback we got on OpenDislike, we decided to transfer this experiment to a more flexible and mature set of widgets, including "Like", "Dislike" and combined "Like + Dislike" buttons. </span>
          </div>
		    </div>


        <div class="navigation" style="clear: both">
          <ul>
            <li <?php echo ($sf_context->getActionName() == 'stream')? 'class="unlike-nav-active"': '""'; ?>><?php echo link_to(strtoupper(__('STREAM')), '@opendislike_stream'); ?></li>
          </ul>
        </div>

		  </div>
		  <!-- end header-wrapper -->
		</div>
		<!-- end header -->
		<div id="content-wrapper" class="clearfix">
		  <?php echo $sf_content; ?>
		  <div style="clear:both;"></div>
		</div>
		<div id="footer" class="clearfix">
		  <div id="footer-wrapper">
		    <div id="footer-content">
	        <div class="navigation clearfix">
	          <span class="footer-info">@powered by <?php echo link_to('yiid', 'http://www.yiid.com'); ?></span>
	          <ul>
	            <li><?php echo link_to_frontend(strtoupper(__('CONTACT_FORM')), 'static/contactform'); ?></li>
	            <li><?php echo link_to_frontend(strtoupper(__('AGB')), 'static/index?category=rechtliches&page=agb'); ?></li>
	            <li><?php echo link_to_frontend(strtoupper(__('IMPRESSUM')), 'static/index?category=rechtliches&page=impressum'); ?></li>
	          </ul>
	          <div style="clear:both;"></div>
	        </div>
		    </div>
		  </div>
		</div>
<?php if (sfConfig::get('app_settings_dev') == 0) { ?>
  <script type="text/javascript">
    var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
    document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
  </script>
  <script type="text/javascript">
    try {
      var pageTracker = _gat._getTracker("UA-105406-40");
      pageTracker._trackPageview();
    } catch(err) {}
  </script>
<?php } ?>
  </body>
</html>


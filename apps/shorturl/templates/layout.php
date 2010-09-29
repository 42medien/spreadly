<?php use_helper('YiidUrl'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" dir="ltr">

<head profile="http://purl.org/uF/2008/03/">

  <?php include_http_metas() ?>
  <?php include_metas() ?>


  <title>YIID.cc - the url shortener</title>

  <?php include_cdn_stylesheets(); ?>
  <?php echo cdn_stylesheet_tag('include/'.sfConfig::get('app_release_name').'.min.css'); ?>
  <!-- CSS -->
  <?php echo cdn_stylesheet_tag('print.css', array('media' => 'print')); ?>

  <link rel="shortcut icon" href="/favicon.ico" />

  <?php include_stylesheets() ?>


  <link rel="commands" title="yiid this" href="<?php echo sfConfig::get('app_settings_url'); ?>/js/browser-plugins/ubiquity/shorturl.js" />

  <?php include_cdn_javascripts(); ?>
  <?php echo cdn_javascript_tag('include/'.sfConfig::get('app_release_name').'.min.js'); ?>
</head>

<body id="top" class="yiidcc module-<?php echo $sf_context->getModuleName() ?> action-<?php echo $sf_context->getActionName() ?>">


	<div id="header-profile">
		<div id="header-wrapper-profile">
			<h1 id="profile-logo">
			  <?php echo link_to_frontend('YIID - Your Internet ID', 'index/index', array('title' => 'YIID - Your Internet ID')); ?>
			</h1>
		</div>
  </div> <!-- #header -->

<!-- ~~~~~~~~~~~~~~~~~~ CONTENT-MAIN-SETTINGS ~~~~~~~~~~~~~~~~~~~~~~~~ -->
	<div id="wrapper">
 		<div id="page">
	  	<div id="main-infos">
      </div><!-- end main-infos -->

<!-- ~~~~~~~~~~~~~~~ CONTENT ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
        <div id="content">
          <div class="outer-content clearfix" id="yiid-content-<?php echo $sf_context->getModuleName() ."-". $sf_context->getActionName() ?>">
            <div class="inner-content-border clearfix">
              <div class="one-col-content">
                <?php echo $sf_content ?>
              </div>
            </div><!-- #inner-content-border -->
          </div><!-- #outer-content -->
        </div><!-- #content -->
      </div> <!-- #page -->
    </div><!-- #wrapper -->

    <?php include_component('general','footer'); ?>
  <script  type="text/javascript">
    jQuery(document).ready( function() {
      <?php if (has_slot('js_document_ready')) { ?>
        <?php include_slot('js_document_ready'); ?>
      <?php } ?>
      <?php //include_partial('global/js_general_ready'); ?>
    });
  </script>

  <?php if (sfConfig::get('app_settings_dev') == 0) { ?>
  <script type="text/javascript">
    var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
    document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
  </script>
  <script type="text/javascript">
    try {
      var pageTracker = _gat._getTracker("UA-105406-37");
      pageTracker._trackPageview();
    } catch(err) {}
  </script>
  <?php } ?>
</body>
</html>
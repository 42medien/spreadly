<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
    <link rel="shortcut icon" href="/favicon.ico" />

    <?php include_partial('global/includes'); ?>

  </head>
  <body class="bg_light clearfix">
    <div id="container" class="bd_round clearfix">
      <div id="error-msg-box">

      </div>
      <div id="header" class="clearfix">
        <div id="header_sub" class="left">
          <a href="<?php echo url_for('homepage'); ?>" id="yiid_logo">&nbsp;</a>
        </div>
	      <div id="header_main" class="left"></div>
	      <div id="header_supp" class="left">
	        <?php include_partial('global/main_navigation'); ?>
	      </div>
	    </div>

      <div id="content" class="clearfix">
        <?php echo $sf_content; ?>
	    </div>

      <?php include_component('general','footer'); ?>

    </div>

	  <?php echo cdn_javascript_tag('100_main/include/platform-'.sfConfig::get('app_release_name').'.js'); ?>

    <script type="text/javascript">
	    jQuery(document).ready( function() {
	      <?php
	      include_partial('global/js_init_general.js');
	      if (has_slot('js_document_ready')) {
	        include_slot('js_document_ready');
	      }
	      include_partial('general/js_init_error.js');
	      ?>
	    });
	  </script>
  </body>
</html>
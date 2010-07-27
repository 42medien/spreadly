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

      <div id="header" class="clearfix">
        <div id="header_sub" class="left"></div>
	    </div>

      <div id="content" class="clearfix">
        <?php echo $sf_content; ?>
	    </div>
    
      <?php include_partial('global/footer'); ?>

    </div>
    
	  <script type="text/javascript" src="/js/100_main/include/platform-<?php echo sfConfig::get('app_release_name') ?>.min.js"></script>
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
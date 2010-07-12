<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
    <link rel="shortcut icon" href="/favicon.ico" />
    <?php //include_stylesheets() ?>
    <script type="text/javascript" src="/js/main/include/platform-<?php echo sfConfig::get('app_release_name') ?>.js"></script>
    <?php //include_javascripts() ?>
    <?php //echo cdn_javascript_tag('include/'.sfConfig::get('app_release_name').'.min.js'); ?>    
  </head>
  <body class="bg_light">
    <div id="container" class="bd_round clearfix">
      
      <div id="header" class="clearfix">

	    </div>
      
      <div id="content" class="separator clearfix">
        
        <div id="content_sub">
          <div id="photo_filter_box" class="bg_light bd_diagonal bd_normal_light">
            test
          </div>
	      </div>
      
	      <div id="content_main">
          <div id="stream_left">
            <div id="stream_left_top"></div>
            <div id="stream_left_bottom" class="bg_light"></div>
            <?php // echo $sf_content ?>
          </div>
	      </div>
	      
	      <div id="content_supp">
	        
	      </div>
      
	    </div>
      
    </div>
    
    <div id="footer" class="clearfix">
	    
	  </div>        
  <script type="text/javascript">
    jQuery(document).ready( function() {
      <?php include_partial('global/jsinit_general.js'); ?>
      <?php if (has_slot('js_document_ready')) { ?>
        <?php include_slot('js_document_ready'); ?>
      <?php } ?>
    });
  </script>    
  </body>
</html>

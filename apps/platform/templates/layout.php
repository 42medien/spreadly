<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
    <link rel="shortcut icon" href="/favicon.ico" />
    <?php include_stylesheets() ?>
    <?php //echo cdn_javascript_tag('include/'.sfConfig::get('app_release_name').'.min.js'); ?>
  </head>
  <body class="bg_light">
    <div id="container" class="bd_round clearfix">

      <div id="header" class="clearfix">
        <div id="header_sub" class="left"></div>
        <div id="header_main" class="left"></div>
        <div id="header_supp" class="left">
          <?php include_partial('global/main_navigation'); ?>
        </div>
	    </div>

      <div id="content" class="clearfix">

        <div id="content_sub" class="left">
          <?php if($this->hasComponentSlot('sidebar_left_main')) { ?>
            <?php include_component_slot('sidebar_left_main'); ?>
          <?php } ?>
	      </div>

	      <div id="content_main" class="left">
          <?php echo $sf_content; ?>
	      </div>

	      <div id="content_supp" class="left">
          <?php if($this->hasComponentSlot('sidebar_right_top')) { ?>
            <?php include_component_slot('sidebar_right_top'); ?>
          <?php } ?>

          <?php if($this->hasComponentSlot('sidebar_right_main')) { ?>
            <?php include_component_slot('sidebar_right_main'); ?>
          <?php } ?>
	      </div>

	    </div>

      <?php include_partial('global/footer'); ?>

    </div>

    <div id="footer" class="clearfix">

	  </div>
  <script type="text/javascript" src="/js/main/include/platform-<?php echo sfConfig::get('app_release_name') ?>.min.js"></script>
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
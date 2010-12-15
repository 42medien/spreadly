<?php use_helper('YiidUrl') ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>

    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>

    <?php include_stylesheets(); ?>
    <script type="text/javascript" src="/js/100_main/include/likepopup-<?php echo sfConfig::get('app_release_name') ?>.js"></script>

    <link rel="shortcut icon" href="/img/global/favicon_16x16.ico" />
  </head>
  <body onunload="LikePopup.refreshParent();">

    <div id="container" class="container_border rounded_corners">

      <?php include_partial('global/branding'); ?>

      <?php
      if ($this->hasComponentSlot('navbar')) {
        include_component_slot('navbar');
      }
      ?>

      <div id="content">
        <?php if($sf_user->hasFlash('error')) { ?>
          <?php include_partial('global/error'); ?>
        <?php } ?>

        <?php if ($this->hasComponentSlot('content_supp') && !$sf_user->hasFlash('error')) { ?>
		    <div id="content_supp" class="clearfix">
		      <?php include_component_slot('content_supp'); ?>
		    </div>
		    <?php } ?>

        <div id="static_content_main">

          <?php echo $sf_content; ?>

        </div>
      </div>
    </div>
	  <script  type="text/javascript">
	    jQuery(document).ready( function() {
	      <?php
	        if (has_slot('js_document_ready')) {
	          include_slot('js_document_ready');
	        }
	      ?>
	    });
	  </script>
  </body>
</html>

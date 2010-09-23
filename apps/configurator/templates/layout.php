<?php use_helper('YiidUrl') ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <link rel="shortcut icon" href="/favicon.ico" />
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
    <?php include_cdn_stylesheets(); ?>
    <!--[if IE 7]>
	    <?php echo cdn_stylesheet_tag('configurator_ie7.css'); ?>
	  <![endif]-->
  </head>
  <body>
    <?php include_partial('global/branding'); ?>

    <?php include_partial('global/navigation'); ?>

    <?php if ($this->hasComponentSlot('content_top')) { ?>
    <div id="content_top" class="clearfix">
      <?php include_component_slot('content_top'); ?>
    </div>
    <?php } ?>

    <div id="content" class="clearfix">
        <?php echo $sf_content; ?>
    </div>

    <?php include_partial('global/footer'); ?>
    <?php echo cdn_javascript_tag('100_main/include/configurator-'.sfConfig::get('app_release_name').'.js'); ?>
    <script type="text/javascript">
      jQuery(document).ready( function() {
        Configurator.init("<?php echo sfContext::getInstance()->getUser()->getCulture(); ?>");
      });
    </script>
  </body>
</html>


<?php use_helper('YiidUrl') ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <link rel="shortcut icon" href="/img/global/favicon_16x16.ico" />
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
    <?php include_stylesheets(); ?>
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
      <div id="content_main">
        <?php echo $sf_content; ?>
      </div>

      <?php if ($this->hasComponentSlot('content_sub')) { ?>
      <div id="content_sub">
        <?php include_component_slot('content_sub'); ?>
      </div>
      <?php } ?>

    </div>

    <?php include_partial('global/footer'); ?>

    <script type="text/javascript" src="/js/100_main/include/statistics-<?php echo sfConfig::get('app_release_name') ?>.js"></script>

    <script type="text/javascript">
      jQuery(document).ready( function() {
      	Yiidit.init("<?php echo $sf_user->getCulture(); ?>");
      });
      jQuery('a[rel*=facebox]').facebox();
      jQuery(window).error(function(pMessage, pFileName, pLineNumber) {

        return true;
      });

    </script>
  </body>
</html>


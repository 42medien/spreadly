<?php use_helper('YiidUrl');?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <link rel="shortcut icon" href="/img/global/favicon_16x16.ico" />

    <link rel="stylesheet" href="/js/100_main/vendor/jquery_ui_datepicker/smothness/jquery_ui_datepicker.css" type="text/css" />
    <link rel="stylesheet" href="/css/vendor/tipTip.css" type="text/css" />
    <link rel="stylesheet" href="/css/vendor/colorpicker.css" type="text/css" />
    <link rel="stylesheet" href="/css/widget/Button.css" type="text/css" />
    <link rel="stylesheet" type="text/css" href="/js/100_main/vendor/jquery_ui_datepicker/timepicker_plug/css/style.css" />
    <link rel="stylesheet" type="text/css" href="/js/100_main/vendor/jquery_ui_datepicker/smothness/jquery_ui_datepicker.css" />
		<link rel="stylesheet" href="/css/vendor/jquery-ui.css" type="text/css" media="all" />
    <link rel="stylesheet/less" href="<?php echo sfConfig::get("app_settings_url");?>/less/main.less" type="text/css" />

    <script type="text/javascript" src="/js/100_main/include/statistics-<?php echo sfConfig::get('app_release_name') ?>.js"></script>
    <script src="/js/100_main/vendor/less-1.0.36.min.js" type="text/javascript"></script>

    <?php include_javascripts();?>


  </head>
  <body>
    <div class="less-error-message"></div>

    <?php include_partial('global/branding'); ?>

    <?php include_partial('global/navigation'); ?>

    <!-- TODO: this has not to be a component slot!!!! -->
    <?php if ($this->hasComponentSlot('content_top') && !$sf_user->isAuthenticated()) { ?>
    <div id="content_top" class="clearfix">
      <?php include_component_slot('content_top'); ?>
    </div>
    <?php } ?>

    <div id="content" class="clearfix">
        <?php echo $sf_content; ?>
    </div>

    <?php include_partial('global/footer'); ?>

    <script type="text/javascript">
    jQuery(document).ready( function() {
      <?php include_partial('global/js_init_general.js'); ?>
      <?php if (has_slot('js_document_ready')) { ?>
        <?php include_slot('js_document_ready'); ?>
      <?php } ?>
    });
    </script>
    <img src="/img/global/ajax-loader-bar-circle.gif" id="general-ajax-loader" />
  </body>
</html>

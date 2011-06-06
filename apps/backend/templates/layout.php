<?php use_helper('YiidUrl');?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <link rel="shortcut icon" href="/img/favicon.ico" />
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
                <link rel="stylesheet" type="text/css" media="screen" href="/sfDoctrinePlugin/css/global.css" />
<link rel="stylesheet" type="text/css" media="screen" href="/sfDoctrinePlugin/css/default.css" />
<link rel="stylesheet" type="text/css" media="screen" href="/css/engineroom/admin.css" />
		<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="/js/100_main/include/backend-<?php echo sfConfig::get('app_release_name') ?>.min.js"></script>
<script type="text/javascript" src="/js/backend/BackendDeal.js"></script>

    <?php use_stylesheet('engineroom/admin.css') ?>
    <?php include_javascripts() ?>
    <?php include_stylesheets() ?>
  </head>
  <body>
    <div class="less-error-message"></div>

    <?php include_partial('global/navigation'); ?>

    <?php if ($this->hasComponentSlot('content_top')) { ?>
    <div id="content_top" class="clearfix">
      <?php include_component_slot('content_top'); ?>
    </div>
    <?php } ?>

    <div id="content" class="clearfix">
        <?php echo $sf_content; ?>
    </div>
		<script type="text/javascript">
			// Custom Checkbox Function
	    jQuery(document).ready( function() {
	      BackendDeal.init();
	    });
	  </script>
  </body>
</html>

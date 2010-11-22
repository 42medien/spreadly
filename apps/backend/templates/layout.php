<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
    <link rel="shortcut icon" href="/favicon.ico" />
    <?php use_stylesheet('admin.css') ?>
    <?php include_javascripts() ?>
    <?php include_stylesheets() ?>
    <link rel="stylesheet" type="text/css" href="/css/001_layout.css"/>
    <link rel="stylesheet" type="text/css" href="/css/002_color.css"/>
    <link rel="stylesheet" type="text/css" href="/css/003_typo.css"/>

  </head>
  <body>
    <div id="container" class="bd_round clearfix">

      <div id="header" class="clearfix">
        <div id="header_sub" class="left"></div>
        <div id="header_main" class="left"><?php include_partial('global/main_navigation'); ?></div>
        <div id="header_supp" class="left"><h3>Statistics Backend</h3></div>
      </div>

      <div id="content" class="clearfix">

        <div id="content_main" class="left">
          <?php echo $sf_content; ?>
        </div>
      </div>
    </div>


    <script type="text/javascript" src="/js/100_main/include/statistics-<?php echo sfConfig::get('app_release_name') ?>.js"></script>

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

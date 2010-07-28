<?php if(sfConfig::get('app_settings_dev') == 1) { ?>
  <?php echo cdn_stylesheet_tag('001_layout.css'); ?>
  <?php echo cdn_stylesheet_tag('002_color.css'); ?>
  <?php echo cdn_stylesheet_tag('003_typo.css'); ?>
<?php } else { ?>
  <?php echo cdn_stylesheet_tag('include/'.sfConfig::get('app_release_name').'.min.css'); ?>
<?php } ?>
    
<?php //echo cdn_javascript_tag('include/'.sfConfig::get('app_release_name').'.min.js'); ?>
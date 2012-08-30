<div id="footer" class="clearfix">
  <!--
  <div id="language_switch">
    <?php // include_component('system', 'language_switch'); ?>
  </div>
   -->

  <ul class="normal_list clearfix">
    <li><?php echo link_to(__('Imprint'), '@imprint');  ?></li>
    <li>-</li>
    <li><?php echo link_to(__('Tos'), '@tos');  ?></li>
    <li>-</li>
    <li><?php echo link_to(__('PRIVACY', null, 'configurator'), '@privacy');  ?></li>
    <li>-</li>
    <li><?php echo __('Contact: %1', array('%1' => mail_to('info@yiid.com')));  ?></li>
  </ul>
</div>

<?php echo cdn_image_tag("img/global/ajax-loader-bar-circle.gif", array('id' => 'general-ajax-loader')); ?>
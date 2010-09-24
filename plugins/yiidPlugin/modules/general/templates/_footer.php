<div id="footer" class="clearfix">
  <!--
  <div id="language_switch">
    <?php // include_component('system', 'language_switch'); ?>
  </div>
   -->

  <ul class="normal_list clearfix">
    <li><?php echo link_to('Impressum', 'static/imprint');  ?></li>
    <li>-</li>
    <li><?php echo link_to('AGB', 'static/tos');  ?></li>
  </ul>
</div>

<?php echo cdn_image_tag("img/global/ajax-loader-bar-circle.gif", array('id' => 'general-ajax-loader')); ?>
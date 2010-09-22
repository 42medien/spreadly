<div id="footer" class="clearfix">
  <!--
  <div id="language_switch">
    <?php // include_component('system', 'language_switch'); ?>
  </div>
   -->

  <?php foreach($pCategories as $lCategory) { ?>
  <ul class="normal_list left">
    <li><h5><?php echo $lCategory->getTitle(); ?></h5></li>
    <?php foreach($lCategory->getCms() as $lCms) { ?>
      <?php if ($lCms->getActive()) { ?>
        <?php if ($lCms->getLink()) { ?>
          <li><?php echo link_to($lCms->getHeadline(), $lCms->getLink()); ?></li>
        <?php } else { ?>
          <?php //var_dump($lCms->getPage());?>
          <li><?php echo link_to($lCms->getHeadline(), 'static/index?category='.$lCms->getCmsCategory()->getPage().'&page='.$lCms->getPage());  ?></li>
        <?php } ?>
      <?php } ?>
    <?php } ?>
  </ul>
  <?php } //end foreach categories ?>
</div>

<?php echo cdn_image_tag("img/global/ajax-loader-bar-circle.gif", array('id' => 'general-ajax-loader')); ?>
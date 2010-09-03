<div id="footer" class="clearfix">

  <div id="language_switch">
    <?php include_component('system', 'language_switch'); ?>
  </div>
</div>
 <div id = "footer-entries">
  <?php foreach($categories as $category) { ?>
  <ul>
    <li><h5><?php echo $category->getTitle(); ?></h5></li>
    <?php foreach($category->getCmss() as $cms) { ?>
      <?php if ($cms->getActive()) { ?>
        <?php if ($cms->getLink()) { ?>
          <li><?php echo link_to($cms->getHeadline(), $cms->getLink()); ?></li>
        <?php } else { ?>
          <li><?php echo link_to_frontend($cms->getHeadline(), 'static/index?category='.$cms->getCmsCategory()->getPage().'&page='.$cms->getPage());  ?></li>
        <?php } ?>
      <?php } ?>
    <?php } ?>
  </ul>
  <?php } //end foreach categories ?>
 </div>

<?php echo cdn_image_tag("/img/global/ajax-loader-bar-circle.gif", array('id' => 'general-ajax-loader')); ?>
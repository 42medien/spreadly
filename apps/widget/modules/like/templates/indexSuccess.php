<?php
use_helper('Avatar', 'Text');

$lImages = $pYiidMeta->getImages();
if ($lImages && count($lImages) > 0) {
  $lImage = $lImages[0];
} else {
  $lImage = "";
}
?>

<div id="content-inner" class="clearfix">
  <form action="" name="popup-like-form" id="popup-like-form" method="post">
    <div id="comment-area" class="clearfix">
      <textarea id="area-like-comment" class="mirror-value bordered gradient shadow-wide" name="like[comment]" placeholder="<?php echo __("add your comment (optional) ..."); ?> <?php echo __('Feel free to add some hashtags, for example:'); ?> #like"></textarea>
    </div>

    <div class="clearfix">
      <p class="area-like-comment-mirror"></p>
      <div id="like-select-img" class="alignleft">
        <div class="scrollable bordered-light shadow-light" id="myscroll">
          <!-- root element for the items -->
          <div class="items alignleft" id="scroll-meta-images">
            <?php include_partial('like/meta_images_list', array('pImages' => $lImages)); ?>
          </div>
        </div>
        <div class="gallery-control clearfix">
          <div id="scroll-button-area" class="clearfix" <?php echo (count($pYiidMeta->getImages()) <= 1)? "style='display:none;'":"";?>>
            <a class="prev browse alignleft slide-back-link" id="slide-back-link"></a>
            <a class="next browse alignright slide-next-link" id="slide-next-link"></a>
          </div>
        </div>
      </div>
      <div class="alignleft clearfix" id="like-content">
        <h4 title="<?php echo $pYiidMeta->getTitle(); ?>">
        <?php echo truncate_text($pYiidMeta->getTitle(), 50); ?>
        </h4>
        <p>
          <?php echo truncate_text($pYiidMeta->getDescription(), 150); ?>
        </p>
        <p title="<?php echo $pYiidMeta->getUrl(); ?>">
          <?php echo truncate_text($pYiidMeta->getUrl(), 50); ?>
        </p>
      </div>
    </div>

    <?php include_component("like", "share_section"); ?>

    <input type="hidden" name="like[thumb]" id="like-img-value" value="<?php echo $lImage; ?>" />
    <input type="hidden" name="like[title]" value="<?php echo htmlspecialchars($pYiidMeta->getTitle()); ?>" />
    <input type="hidden" name="like[descr]" value="<?php echo htmlspecialchars($pYiidMeta->getDescription()); ?>" />
    <input type="hidden" name="like[url]" value="<?php echo $pYiidMeta->getUrl(); ?>" />
    <input type="hidden" name="like[tags]" value="<?php echo $sf_request->getParameter('tags'); ?>" />
    <input type="hidden" name="like[clickback]" value="<?php echo $sf_request->getParameter('clickback'); ?>" />
  </form>
</div>
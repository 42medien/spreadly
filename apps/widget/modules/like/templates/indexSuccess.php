<form action="<?php echo url_for('@save_like'); ?> " name="popup-like-form" id="popup-like-form" method="post">
<?php
$lImages = $pYiidMeta->getImages();
if ($lImages && count($lImages) > 0) {
  $lImage = $lImages[0];
} else {
  $lImage = "";
}
?>

    <input type="hidden" name="like[thumb]" id="like-img-value" value="<?php echo $lImage; ?>" />
    <input type="hidden" name="like[title]" value="<?php echo $pYiidMeta->getTitle(); ?>" />
    <input type="hidden" name="like[descr]" value="<?php echo $pYiidMeta->getDescription(); ?>" />
    <input type="hidden" name="like[url]" value="<?php echo $pYiidMeta->getUrl(); ?>" />
    <input type="hidden" name="like[tags]" value="<?php echo $sf_request->getParameter('tags'); ?>" />

    <div class="whtboxtopwide spreadsel_box">
      <div class="rcor clearfix">
        <div class="alignleft checklist">
          <ul class="clearfix">
            <?php foreach($pIdentities as $lIdentity) {?>
            <li>
              <label><input type="checkbox" name="like[oiids][]" value="<?php echo $lIdentity->getId(); ?>" /></label><?php echo image_tag("/img/".$lIdentity->getCommunity()->getCommunity()."-favicon.gif", array("alt" => $lIdentity->getCommunity()->getName(), "title" => $lIdentity->getCommunity()->getName())); ?>
            </li>
            <?php } ?>
          </ul>
        </div>
        <div class="alignright comment">
          <span><?php echo __("Preview for Facebook"); ?></span><br>
          <?php echo __("(other services may look different)"); ?>
        </div>
      </div>
    </div>
    <div class="wht-contentbox clearfix">
      <div class="commentlist spreadbox">
        <div class="clearfix profilebox">
          <div class="alignleft proimg">
            <img src="img/spread-proimg.jpg" alt="Profile" title="Profile">
          </div>
          <div class="alignright prodetail">
            <h3>
              <?php echo $sf_user->getUser()->getFullname(); ?> via Spread.ly
            </h3>
            <p>

            </p>
            <div class="clearfix">
              <div class="alignleft subdetail_img">
                <div class="scrollable" id="myscroll">
                   <!-- root element for the items -->
                   <div class="items alignleft subdetail_img" id="scroll-meta-images">
                     <?php include_partial('like/meta_images_list', array('pImages' => $lImages)); ?>
                   </div>
                </div>
                <div class="gallery_cantrol">
                  <div id="scroll-button-area" <?php echo (count($pYiidMeta->getImages()) <= 1)? "style='display:none;'":"";?>>
                    <a class="prev browse left slide-back-link" id="slide-back-link"></a>
                    <a class="next browse left slide-next-link" id="slide-next-link"></a>
                    <span id="img-counter">1</span>/<span id="img-number"><?php echo count($pYiidMeta->getImages()); ?></span>
                  </div>
                  Chose image
                </div>
              </div>
              <div class="alignleft sub_detail">
                <h4>
                  <?php echo $pYiidMeta->getTitle(); ?>
                </h4>
                <p>
                  <?php echo $pYiidMeta->getUrl(); ?>
                </p>
                <p class="last">
                  <?php echo $pYiidMeta->getDescription(); ?>
                </p>
              </div>
            </div>
          </div>
        </div>
        <div class="comment_box clearfix">
          <label class="alignleft comment_post">
          <textarea rows="2" cols="2" id="area-like-comment" name="like[comment]"><?php echo __("add your comment (optional) ..."); ?></textarea>
          </label> <span class="alignleft btn"><input type="submit" id="popup-send-like-button" value="Spread It" /></span>
        </div>
      </div>
    </div>
</form>
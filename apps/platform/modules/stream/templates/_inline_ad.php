<?php
use_helper('Text');
?>

<li class="clearfix stream_item ad_stream_item" id="ad_item_<?php echo $pAd->getSoId(); ?>" data-obj='{"action":"StreamItem.getDetailAction", "callback":"ItemDetail.show", "itemid":"<?php echo $pAd->getSoId(); ?>", "css":"{\"itemid\":\"ad_item_<?php echo $pAd->getSoId(); ?>\"}"}'>
  <div class="whats_hot_stream_item">
    <div class="clearfix">
      <div class="whats_hot_stream_icon left">
        <span class="stream_icon stream_icon_location">&nbsp;</span>
      </div>
      <div class="left whats_hot_stream_head_left">
        <div class="clearfix">
          <div class="left so_headline_left">
            <?php echo image_tag('http://getfavicon.appspot.com/'.$pAd->getUrl(), array('class' => 'icon_small_service left', 'width' => '16px', 'height' => '16px')); ?>
            <span class="url left"><?php echo __("on a personal note"); ?></span>
          </div>
        </div>
        <div class="clearfix whats_hot_info_area">
          <p class="text_important"><?php echo $pAd->getTitle(); ?></p>
          <p title="<?php echo $pAd->getUrl(); ?>"><?php echo link_to(UrlUtils::getShortUrl($pAd->getUrl()), url_for($pAd->getUrl(), true), array('class' => 'url')); ?></p>
          <p class="main_text"><?php echo $pAd->getDescription(); ?></p>
        </div>
      </div>
      <div class="right preview_information">
        <img alt="<?php echo $pAd->getUrl(); ?>" width="100px" height="80px"  src="http://communipedia.v2.websnapr.com/?url=<?php echo $pAd->getUrl(); ?>&sh=80&sw=100">
      </div>
    </div>
  </div>
</li>
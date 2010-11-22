<?php use_helper('YiidUrl', 'Text'); ?>

<?php $pObject = $pAd->getSocialObject() ?>

<li class="clearfix stream_item ad_new_stream_item" id="stream_ad_item_<?php echo $pAd->getId(); ?>" data-obj='{"action":"StreamItem.getDetailAction", "callback":"ItemDetail.show", "itemid":"<?php echo  $pObject->getId(); ?>", "css":"{\"itemid\":\"stream_ad_item_<?php echo  $pAd->getId(); ?>\"}"}'>
<div class="so_image left">
  <div class="sharing_friend_outer left">
  </div>
  <div class="sharing_friend_inner">
    <img alt="<?php echo $pAd->getUrl(); ?>" width="48px" height="38px"  src="http://communipedia.v2.websnapr.com/?url=<?php echo $pAd->getUrl(); ?>&sh=48&sw=38">
  </div>
</div>

<div class="so_information left">
  <div class="green_arrow">

    <div class="clearfix">
	    <div class="green_top_middle left">
        <div class="green_top_left left"></div>
	      <div class="info_area clearfix">
	        <div class="left so_headline_left">
	          <span class="user_share text_important left"></span>
	          <span class="url left"><?php echo __("on a personal note"); ?></span>
	        </div>
	        <div class="right so_headline_right">
          <?php echo $pObject->getLikeCount(); ?><span class="thumb_up icon_small_use like-dislike" id="like-thumb">&nbsp;</span>
          <?php echo $pObject->getDislikeCount(); ?><span class="thumb_down icon_small_use like-dislike" id="dislike-thumb">&nbsp;</span>
		      </div>
	      </div>
	    </div>
    </div>

    <div class="clearfix">
      <div class="green_middle_middle">
          <p class="so_comment text_important"><?php echo truncate_text($pObject->getTitle(), 35, '...'); ?></p>
          <p class="so_comment" title="<?php echo $pAd->getUrl(); ?>"><?php echo link_to(UrlUtils::getShortUrl($pAd->getUrl()), url_for($pAd->getUrl(), true), array('class' => 'url')); ?></p>
          <p class="so_comment main_text"></p>
      </div>
    </div>

    <div class="clearfix">
      <div class="green_bottom_middle left">
        <div class="green_bottom_left left"></div>
      </div>
    </div>

  </div>
</div>
</li>